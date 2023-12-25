<?php 
    $Form = new Folds\Builder();

    $InputUsername = [
        $Form -> Label("Email", ["for|username"]),
        $Form -> Input("text", ["nm|username", "id|username", "cl|form-control", "ph| Enter email"]),
        $Form -> Element("small", ["id|usernameHelp", "cl|form-text text-muted"],["We'll never share your information with anyone else."])
    ];

    $InputPassword = [
        $Form -> Label("Password", ["for|password"]),
        $Form -> Input("password", ["nm|password", "id|password", "cl|form-control", "ph|Password"])
    ];

    $InputRememberMe = [
        $Form -> Label("Remember Me", ["for|exChk1", "cl|form-check-Label"]),
        $Form -> Input("checkbox", ["nm|rememberMe", "id|exChk1", "cl|form-check-Input"])
    ];
    
    return $Form -> form(["ac|UserLogin", "method|get", "style|width:50%;", "cl|spadeMe spadeScript", "id|login_form"],[
            // $Form -> Element("div",["cl|form_message text-danger fw-bold"]),
            $Form -> div(["cl|form-group"], $InputUsername),
            $Form -> div(["cl|form-group"], $InputPassword),
            // $Form -> div(["cl|form-group form-check"], $InputRememberMe),
            $Form -> button("submit", ["cl|btn btn-primary my-2"])
            ]
        );