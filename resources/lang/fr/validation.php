<?php
return [
    'custom' => [
        'email' => [
            'email' => "L'adresse mail n'est pas correcte",
            'max' => "L'adresse mail doit faire moins de :max caractères",
        ],
        'username' => [
            'min' => "Le nom d'utilisateur doit faire plus de :min caractères",
            'max' => "Le nom d'utilisateur doit faire moins de :max caractères",
            'required' => "Un nom d'utilisateur doit être défini",
            'alpha_num' => "Le nom d'utilisateur ne doit contenir que des lettres et des chiffres"
        ],
        'password' => [
            'min' => "Le mot de passe doit faire plus de :min caractères",
            'max' => "Le mot de passe doit faire moins de :max caractères",
            'required' => "Un mot de passe doit être défini",
            'alpha_num' => "Le mot de passe ne doit contenir que des lettres et des chiffres"
        ]
    ]
];
?>