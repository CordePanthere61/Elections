<?php


class RegisterValidator
{

    private $regexForName = "/^[^0-9]{2,255}$/i";
    private $regexPhoneNumber = "/^[(]?[0-9]{3}[)]?[\s\-]?[0-9]{3}[\-\s]?[0-9]{4}$/";
    private $regexSinNumber = "/^[0-9]{9}$/";
    private $regexPassword = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";


    public function areFieldsValid(): bool
    {
        $validFields = 0;
        $validFields += $this->validateFirstName();
        $validFields += $this->validateLastName();
        $validFields += $this->validatePhone();
        $validFields += $this->validateSinNumber();
        $validFields += $this->validatePassword();
        return ($validFields == 5);
    }

    private function validateFirstName(): int
    {
        if (!preg_match($this->regexForName, $_POST['firstname'])) {
            $_SESSION['invalidFirstName'] = "Le prénom doit contenir que des lettres";
            return 0;
        }
        return 1;
    }

    private function validateLastName(): int
    {
        if (!preg_match($this->regexForName, $_POST['lastname'])) {
            $_SESSION['invalidLastName'] = "Le nom doit contenir que des lettres";
            return 0;
        }
        return 1;
    }

    private function validatePhone(): int
    {
        if (!preg_match($this->regexPhoneNumber, $_POST['phoneNumber'])) {
            $_SESSION['invalidPhoneNumber'] = "Le numéro de téléphone doit respecter le format : (XXX) XXX-XXXX";
            return 0;
        }
        return 1;
    }

    private function validateSinNumber(): int
    {
        if (!preg_match($this->regexSinNumber, $_POST['sinNumber'])) {
            $_SESSION['invalidSinNumber'] = "Le NAS doit respecter le format : 123456789";
            return 0;
        }
        return 1;
    }

    private function validatePassword() : int
    {
        if ($_POST['password'] != $_POST['confirmPassword']) {
            $_SESSION['invalidPassword'] = "Les deux mots de passes doivent être identiques";
            return 0;
        }
        if (strpos($_POST['password'], $_POST['firstname']) || strpos($_POST['password'], $_POST['lastname'])) {
            $_SESSION['invalidPassword'] = "Le mot de passe ne doit pas contenir le prénom ni le nom";
            return 0;
        }
        if (!preg_match($this->regexPassword, $_POST['password'])) {
            $_SESSION['invalidPassword'] = "Le mot de passe doit contenir minimum 8 charactères, 1 majuscule et 1 symbole spécial (@$!%*#?&)";
            return 0;
        }
        return 1;
    }
}