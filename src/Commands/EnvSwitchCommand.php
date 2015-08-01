<?php namespace IKovbas\EnvSwitcher\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EnvSwitchCommand extends AbstractCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'env:switch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch between environments by changing .env file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {

        if ($this->option('save')) {

            // Save current environment
            $this->saveEnvironment();

        } elseif ($this->argument('env')) {

            // Switch to target environment
            $this->switchEnvironment();

        } else {

            // Show current environment
            $this->showEnvironment();

        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return [
            ['env', InputArgument::OPTIONAL, 'The environment name to switch to'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['save', null, InputOption::VALUE_NONE, 'Save the current .env to a $APP_ENV.env file before switching.', null],
        ];
    }
}