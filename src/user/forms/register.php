<?php 
    $frm = new folds\builder();

    $inp_email = [
        $frm -> label("Email Address", ["for|username"]),
        $frm -> input("text", ["nm|username", "id|username", "cl|form-control", "ph|Enter email"])
    ];

    $inp_pass = [
        $frm -> label("Password", ["for|password"]),
        $frm -> input("password", ["nm|password", "id|password", "cl|form-control", "ph|Password"])
    ];

    $inp_pass_conf = [
        $frm -> label("Confirm Password", ["for|password_confirm"]),
        $frm -> input("password", ["nm|password_confirm", "id|password_confirm", "cl|form-control", "ph|Confirm Password"])
    ];

    $inp_fname = [
        $frm -> label("First Name", ["for|fname"]),
        $frm -> input("text", ["nm|fname", "id|fname", "cl|form-control", "ph|First Name"])
    ];

    $inp_lname = [
        $frm -> label("Last Name", ["for|lname"]),
        $frm -> input("text", ["nm|lname", "id|lname", "cl|form-control", "ph|Last Name"])
    ];

    return $frm -> form(["ac|register_new_user", "cl|card-form spadeMe spadeScript"],[
        // $frm -> elem("div",["cl|form_message text-danger fw-bold"]),
        $frm -> div(["cl|row"],[
            $frm -> div(["cl|col"], $inp_fname),
            $frm -> div(["cl|col"], $inp_lname)
        ]),
        $frm -> div(["cl|form-group"], $inp_email),
        $frm -> div(["cl|row"],[
            $frm -> div(["cl|col"], $inp_pass),
            $frm -> div(["cl|col"], $inp_pass_conf)
        ]),
        $frm -> button("submit", ["cl|btn btn-primary my-2"])
        ]
    );
      
?>