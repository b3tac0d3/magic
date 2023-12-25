<?php 
    $Form = new Folds\Builder();

    $InputEmail = [
        $Form -> Label("Email Address", ["for|username"]),
        $Form -> Input("text", ["nm|username", "id|username", "cl|form-control", "ph|Enter email"])
    ];

    $InputPassword = [
        $Form -> Label("Password", ["for|password"]),
        $Form -> Input("password", ["nm|password", "id|password", "cl|form-control", "ph|Password"])
    ];

    $InputPasswordConfirm = [
        $Form -> Label("Confirm Password", ["for|password_confirm"]),
        $Form -> Input("password", ["nm|password_confirm", "id|password_confirm", "cl|form-control", "ph|Confirm Password"])
    ];

    $InputFirstName = [
        $Form -> Label("First Name", ["for|fname"]),
        $Form -> Input("text", ["nm|fname", "id|fname", "cl|form-control", "ph|First Name"])
    ];

    $InputLastName = [
        $Form -> Label("Last Name", ["for|lname"]),
        $Form -> Input("text", ["nm|lname", "id|lname", "cl|form-control", "ph|Last Name"])
    ];

    return $Form -> Form(["ac|register_new_user", "cl|w-75 spadeMe spadeScript"],[
        // $Form -> elem("Div",["cl|Form_message text-danger fw-bold"]),
        $Form -> Div(["cl|row"],[
            $Form -> Div(["cl|col"], $InputFirstName),
            $Form -> Div(["cl|col"], $InputLastName)
        ]),
        $Form -> Div(["cl|form-group"], $InputEmail),
        $Form -> Div(["cl|row"],[
            $Form -> Div(["cl|col"], $InputPassword),
            $Form -> Div(["cl|col"], $InputPasswordConfirm)
        ]),
        $Form -> button("submit", ["cl|btn btn-primary my-2"])
        ]
    );
      
?>