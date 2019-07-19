<?php

function make($model, $overrides = [], $count = 1)
{
    if ($count < 2)
        return factory($model)->make($overrides);
    else
        return factory($model, $count)->make($overrides);
}

function create($model, $overrides = [], $count = 1)
{
    if ($count < 2)
        return factory($model)->create($overrides);
    else
        return factory($model, $count)->create($overrides);
}


// returns generated api header with or without token
function generateAPIHeaders(App\User $user = null, $token = null)
{
    $headers = [
        'Accept' => 'application/json',
    ];
    if ($user != null) {
        $headers['Authorization'] = "Bearer " . $user->createToken('90days')->accessToken;
    }

    if ($token != null) {
        $headers['authorization'] = "Bearer " . $token;
    }

    return $headers;
}
