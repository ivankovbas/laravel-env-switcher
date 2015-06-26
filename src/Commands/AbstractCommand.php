<?php namespace IKovbas\EnvSwitcher\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AbstractCommand extends Command{

    /**
     * Save current environment to custom file
     */
    protected function saveEnvironment() {

        // Determinate path to .env file
        $dotenv_path            = getcwd() . '/.env';

        // Determinate current environment and file name for it
        $current_env            = getenv('APP_ENV');
        $current_env_file_name  = $this->getEnvFileName($current_env);
        $current_env_file_path  = getcwd() . '/' . $current_env_file_name;

        // Save current environment to custom file
        $this->copyFile($dotenv_path, $current_env_file_path);

        // Show message
        $this->info('Environmental config was successfully saved to <comment>' . $current_env_file_name . '</comment>');
    }

    /**
     * Switch to target environment:
     * copy target environment file to .env
     *
     */
    protected function switchEnvironment() {

        // Determinate path to .env file
        $dotenv_path            = getcwd() . '/.env';

        // Determinate current
        $current_env            = getenv('APP_ENV');

        // Determinate target environment and file name for it
        $target_env             = $this->argument('env');
        $target_env_file_name   = $this->getEnvFileName($target_env);
        $target_env_file_path   = getcwd() . '/' . $target_env_file_name;

        // TODO: Add a checking, if current environment was saved

        // Check if target env file exist
        if (!File::exists($target_env_file_path)) {
            $this->error('Cannot switch to environment:<info> ' . $target_env . ' </info>because<info> ' . $target_env_file_name .' </info>doesn\'t exist');
            return;
        }

        // Copy target env data to .env file
        $this->copyFile($target_env_file_path, $dotenv_path);

        // Show message
        $this->info('Successfully switched from <comment>' . $current_env . '</comment> to <comment>' . $target_env . '</comment>');
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