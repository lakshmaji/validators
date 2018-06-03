<?php

namespace Lakshmaji\Validators\Console\Commands\Creators;

use Doctrine\Common\Inflector\Inflector;
use Illuminate\Filesystem\Filesystem;

/**
 * ValidatorCreator
 *
 * @author     lakshmaji 
 * @package    Validator
 * @version    1.0.0
 * @since      Class available since Release 1.0.0
 */
class ValidatorCreator
{
    /**  @var Filesystem */
    protected $files;

    /** @var */
    protected $validator;

    /**  @var */
    protected $model;

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Create the validator.
     *
     * @param $validator
     * @param $model
     *
     * @return int
     */
    public function create($validator)
    {
        $this->setValidator($validator);
        $this->createDirectory();

        return $this->createClass();
    }

    protected function createDirectory()
    {
        $directory = $this->getDirectory();

        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Get the validator directory.
     *
     * @return mixed
     */
    protected function getDirectory()
    {
        return config('validator.validator_path');
    }

    /**
     * Get the validator name.
     *
     * @return mixed|string
     */
    protected function getValidatorName()
    {
        $name = $this->getValidator();

        if (!strpos($name, 'Validator') !== false) {
            $name .= 'Validator';
        }

        return $name;
    }

    /**
     * Get the model name.
     *
     * @return string
     */
    protected function getModelName()
    {
        $model = $this->getModel();

        if (isset($model) && !empty($model)) {
            $name = $model;
        } else {
            $name = Inflector::singularize($this->stripValidatorName());
        }

        return $name;
    }

    /**
     * Get the stripped validator name.
     *
     * @return string
     */
    protected function stripValidatorName()
    {
        return ucfirst(strtolower(str_replace('validator', '', $this->getValidator())));
    }

    /**
     * Get the populate data.
     *
     * @return array
     */
    protected function getPopulateData()
    {
        return [
            'validator_namespace' => config('validator.validator_namespace'),
            'validator_class' => $this->getValidatorName(),
        ];
    }

    /**
     * Get the path.
     *
     * @return string
     */
    protected function getPath()
    {
        return $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getValidatorName() . '.php';
    }

    /**
     * Get the stub.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->files->get($this->getStubPath() . 'validator.stub');
    }

    /**
     * Get the stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__ . '/../../../resources/stubs/';
    }

    /**
     * Populate the stub.
     *
     * @return mixed
     */
    protected function populateStub()
    {
        $data = $this->getPopulateData();
        $stub = $this->getStub();

        foreach ($data as $key => $value) {
            $stub = str_replace($key, $value, $stub);
        }

        return $stub;
    }

    /**
     * @return mixed
     */
    protected function createClass()
    {
        return $this->files->put($this->getPath(), $this->populateStub());
    }
}
