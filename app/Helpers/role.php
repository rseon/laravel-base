<?php

if(!function_exists('display_role')) {

    /**
     * Display role name
     *
     * @param string $name
     * @param bool|null $with_label
     * @return string
     */
    function display_role(string $name, ?bool $with_label = true): string
    {
        $color = 'black';

        switch($name) {
            case App\Models\User::ROLE_ADMIN:
                $name = __('Administrator');
                $color = 'primary';
                break;
            case App\Models\User::ROLE_USER:
                $name = __('User');
                $color = 'secondary';
                break;
        }

        if($with_label) {
            $name = '<span class="badge badge-'.$color.'">'.$name.'</span>';
        }

        return $name;
    }
}
