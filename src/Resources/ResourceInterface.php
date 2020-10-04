<?php

namespace Leeto\Admin\Resources;


interface ResourceInterface
{
    public function indexFields();

    public function exportFields();

    public function formFields();
}