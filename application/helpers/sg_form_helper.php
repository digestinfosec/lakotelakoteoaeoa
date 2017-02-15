<?php

function sg_field($type, $name, $value, $attr = array(), $default = null, $options = array())
{
    return \Scienceguard\SG_Form::field($type, $name, $value, $attr, $default, $options);
}
