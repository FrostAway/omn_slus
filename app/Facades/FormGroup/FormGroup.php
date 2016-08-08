<?php

namespace App\Facades\FormGroup;

use Form;

class FormGroup {

    public function addClass($args) {
        if (!empty($args) && isset($args['class'])) {
            $args['class'] .= ' form-control';
        } else {
            $args['class'] = 'form-control';
        }
        return $args;
    }

    public function gText($label, $name, $value = null, $args = [], $col1 = 3, $col2 = 9) {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?php echo $label; ?></label>
            <div class="col-sm-<?= $col2 ?>">
                <?php echo Form::text($name, $value, $this->addClass($args)); ?>
            </div>
        </div>
        <?php
    }
    
    public function gEmail($label, $name, $value = null, $args = [], $col1 = 3, $col2 = 9) {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?php echo $label; ?></label>
            <div class="col-sm-<?= $col2 ?>">
                <?php echo Form::email($name, $value, $this->addClass($args)); ?>
            </div>
        </div>
        <?php
    }

    public function gNumber($label, $name, $value = null, $args = [], $col1 = 3, $col2 = 9) {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?php echo $label; ?></label>
            <div class="col-sm-<?= $col2 ?>">
                <?php echo Form::number($name, $value, $this->addClass($args)); ?>
            </div>
        </div>
        <?php
    }

    public function gPassword($label, $name, $args = [], $col1 = 3, $col2 = 9) {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?php echo $label; ?></label>
            <div class="col-sm-<?= $col2 ?>">
                <?php echo Form::password($name, $this->addClass($args)); ?>
            </div>
        </div>
        <?php
    }

    public function gTextArea($label, $name, $value, $args = [], $col1 = 3, $col2 = 9) {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?php echo $label; ?></label>
            <div class="col-sm-<?= $col2 ?>">
                <?php echo Form::textarea($name, $value, $this->addClass($args)); ?>
            </div>
        </div>
        <?php
    }

    public function gSelect($label, $name, $lists, $value, $args = [], $col1 = 3, $col2 = 9) {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?php echo $label; ?></label>
            <div class="col-sm-<?= $col2 ?>">
                <?php echo Form::select($name, $lists, $value, $this->addClass($args)); ?>
            </div>
        </div>
        <?php
    }

    public function gSubmit($value, $args = [], $col1 = 3, $col2 = 9) {
        if (!empty($args) && isset($args['class'])) {
            $args['class'] .= ' btn';
        } else {
            $args['class'] = 'btn';
        }
        ?>
        <div class="form-group row">
            <div class="col-sm-<?= $col2 ?> col-sm-offset-<?= $col1 ?>">
                <?php echo Form::submit($value, $args); ?>
            </div>
        </div>
        <?php
    }
    
    // echo
    public function gShow($label, $value, $col1=3, $col2=9)
    {
        ?>
        <div class="form-group row">
            <label class="col-sm-<?= $col1 ?>"><?= $label; ?></label>
            <div class="col-sm-<?= $col2 ?>"><?= $value ?></div>
        </div>
        <?php
    }

    public function text($label, $name, $value, $args = []) {
        ?>
        <label><?php echo $label; ?></label>
        <?php
        echo Form::text($name, $value, $this->addClass($args));
    }
    
    public function textarea($label, $name, $value, $args = []) {
        ?>
        <label><?php echo $label; ?></label>
        <?php
        echo Form::textarea($name, $value, $this->addClass($args));
    }
    
    public function select($label, $name, $lists, $value, $args = []) {
        ?>
        <label><?php echo $label; ?></label>
        <?php
        echo Form::select($name, $lists, $value, $this->addClass($args));
    }

}
