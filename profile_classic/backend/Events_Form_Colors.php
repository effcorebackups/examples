<?php

######################################################################
### Copyright © 20NN—20NN Author/Rightholder. All rights reserved. ###
######################################################################

namespace effcore\modules\profile_classic;

use effcore\Form_part;
use effcore\Module;
use effcore\Storage;

abstract class Events_Form_Colors {

    static function on_build($event, $form) {
        $form->child_insert(
            Form_part::get('form_colors__profile_classic'), 'profile_classic'
        );
    }

    static function on_init($event, $form, $items) {
        $settings = Module::settings_get('profile_classic');
        $items['*color_custom__head_id']->value_set($settings->color_custom__head_id);
        $items['*color_custom__foot_id']->value_set($settings->color_custom__foot_id);
    }

    static function on_submit($event, $form, $items) {
        switch ($form->clicked_button->value_get()) {
            case 'save':
                $storage = Storage::get('data');
                $storage->changes_insert('profile_classic', 'update', 'settings/profile_classic/color_custom__head_id', $items['*color_custom__head_id']->value_get(), false);
                $storage->changes_insert('profile_classic', 'update', 'settings/profile_classic/color_custom__foot_id', $items['*color_custom__foot_id']->value_get()       );
                break;
            case 'reset':
                $storage = Storage::get('data');
                $storage->changes_delete('profile_classic', 'update', 'settings/profile_classic/color_custom__head_id', false);
                $storage->changes_delete('profile_classic', 'update', 'settings/profile_classic/color_custom__foot_id'       );
                static::on_init(null, $form, $items);
                break;
        }
    }

}
