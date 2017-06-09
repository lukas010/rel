<?php

function translate($name)
{
    $words = array(
        'username required' => 'Vartotojo vardas privalomas.',
        'username > 2' => 'Vartotojo vardas turi būti ilgesnis nei 2 simboliai.',
        'username < 32' => 'Vartotojo vardas turi būti trumpesnis nei 32 simboliai.',
        'username exists' => 'Toks vartotojo vardas jau egzistuoja.',
        'password required' => 'Slaptažodis privalomas.',
        'password > 6' => 'Slaptažodis turi būti ilgesnis nei 6 simboliai.',
        'password_again required' => 'Slaptažodžio pakartojimas privalomas.',
        'password = password_again' => 'Slaptažodžiai privalo sutapti',
        'name required' => 'Vardas ir pavardė privalomi.',
        'username > 2' => 'Vartotojo vardas turi būti ilgesnis nei 2 simboliai.',
        'username < 32' => 'Vartotojo vardas turi būti trumpesnis nei 32 simboliai.',
        'username exists' => 'Toks vartotojo vardas jau egzistuoja.',
        'name > 2' => 'Vardas ir pavardė turi būti ilgesni nei 2 simboliai.',
        'name < 64' => 'Vardas ir pavardė turi būti trumpesni nei 64 simboliai.',
        'users_radio_list required' => 'Pažymėkite asmenį, kuriam skiriate užduotį.',
        'task required' => 'Privalote įrašyti užduotį.'
    );

    foreach ($words as $key => $value) {
        if ($key === $name) {
            return $value;
        }
    }

    return $name;
}
