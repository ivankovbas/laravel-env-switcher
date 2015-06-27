<?php namespace IKovbas\EnvSwitcher\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AbstractCommand extends Command{

    /**
     * Path to .env file
     *
     * @var string
     */
    protected $dotenv_path;

    /**
     * Current environment name
     *
     * @var string
     */
    protected $current_env;

    /**
     * @var string
     */
    protected $current_env_file_name;

    /**
     * @var string
     */
    protected $current_env_file_path;

    protected $messages = [
        'save.success'              => 'Environmental config was successfully saved to <comment>%s</comment>',
        'save.ask'                  => 'You have unsaved changes for environment "%s", would you like to save changes before switching? [Y, N]',
        'switch.success'            => 'Successfully switched from <comment>%s</comment> to <comment>%s</comment>',
        'switch.error.not_exist'    => 'Cannot switch to environment:<info> %s </info>because<info> %s </info>doesn\'t exist'
    ];

    public function __construct() {
        parent::__construct();

        // Determinate path to .env file
        $this->dotenv_path              = getcwd() . '/.env';

        // Determinate current environment data
        $this->current_env              = getenv('APP_ENV');
        $this->current_env_file_name    = $this->getEnvFileName($this->current_env);
        $this->current_env_file_path    = getcwd() . '/' . $this->current_env_file_name;
    }

    /**
     * Save current environment to custom file
     */
    protected function saveEnvironment() {

        // Save current environment to custom file
        $this->copyFile($this->dotenv_path, $this->current_env_file_path);

        // Show message
        $this->info(sprintf($this->messages['save.success'], $this->current_env_file_name));
    }

    /**
     * Switch to target environment:
     * copy target environment file to .env
     *
     */
    protected function switchEnvironment() {

        // Determinate target environment and file name for it
        $target_env             = $this->argument('env');
        $target_env_file_name   = $this->getEnvFileName($target_env);
        $target_env_file_path   = getcwd() . '/' . $target_env_file_name;

        // Check if .env was saved to the custom .env.$APP_ENV file
        if (!$this->isEnvironmentSaved()) {
            $this->askToSave();
        }

        // Check if target env file exist
        if (!File::exists($target_env_file_path)) {
            $this->error(sprintf($this->messages['switch.error.not_exist'], $target_env, $target_env_file_name));
            return;
        }

        // Copy target env data to .env file
        $this->copyFile($target_env_file_path, $this->dotenv_path);

        // Show message
        $this->info(sprintf($this->messages['switch.success'], $this->current_env, $target_env));
    }

    /**
     * Ask user if he want to save env and save it
     */
    protected function askToSave() {

        // Ask user if he wants to save environment
        $answer = $this->askWithCompletion(sprintf($this->messages['save.ask'], $this->current_env), ["Y", "N"], "Y");

        // Save environment if yes
        if ($answer == "Y") {
            $this->saveEnvironment();
        }
    }

    /**
     * Method check if the current environment is saved to custom file
     *
     * @return bool
     */
    protected function isEnvironmentSaved() {

        // Check if custom env file exists
        if (!File::exists($this->current_env_file_path)) {
            return false;
        }

        // Check if content of .env is equals to .env.$APP_ENV
        return (File::get($this->dotenv_path) == File::get($this->current_env_file_path));
    }

    /**
     * Show current environment
     */
    protected function showEnvironment() {
        $this->info('Current application environment: <comment>' . getenv('APP_ENV') . '</comment>');
    }

    /**
     * Copy content from file $from to file $to
     *
     * @param $from
     * @param $to
     */
    protected function copyFile($from, $to) {
        File::put($to, File::get($from), true);
    }

    /**
     * Generate env file name
     *
     * @param $env_name
     * @return string
     */
    protected function getEnvFileName($env_name) {
        // TODO: Load file name template from configs
        return ".env.$env_name";
    }

} 