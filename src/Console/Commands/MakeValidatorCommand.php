<?php

namespace Lakshmaji\Validators\Console\Commands;

use Illuminate\Console\Command;
use Lakshmaji\Validators\Console\Commands\Creators\ValidatorCreator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * MakeValidatorCommand
 *
 * @author     lakshmaji 
 * @package    Repository
 * @version    1.0.0
 * @since      Class available since Release 1.0.0
 */
class MakeValidatorCommand extends Command
{
    /** The name and signature of the console command. @var string */
    protected $signature = 'make:validator {name : Name of the Validator}';

    /** The console command description. @var string */
    protected $description = 'Create a new validator class';

    /** @var RepositoryCreator */
    protected $creator;

    /** @var */
    protected $composer;

    /**
     * @param RepositoryCreator $creator
     */
    public function __construct(ValidatorCreator $creator)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->argument('name');
        $this->writeRepository($arguments);
        $this->composer->dumpAutoloads();
    }

    /**
     * @param $arguments
     * @param $options
     */
    protected function writeRepository($validator)
    {
        if ($this->creator->create($validator)) {
            $this->info('Successfully created the validator class');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['validator', InputArgument::REQUIRED, 'The validator name.'],
        ];
    }

}
