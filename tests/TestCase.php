<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PhpParser\Node\Expr\Instanceof_;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $model
     */
    protected function clearAddedData($model)
    {
        if ($model) {
            $model->delete();
        }
    }
}
