<?php


class RegisterValidator
{

    private $regexForName = "/^[^0-9]{2,255}$/i";
    private $regexPhoneNumber = "/^[(]?[0-9]{3}[)]?[\s\-]?[0-9]{3}[\-\s]?[0-9]{4}$/";
    private $regexSinNumber = "/^[0-9]{9}$/";


    public function areFieldsValid(): bool
    {
        $validFields = 0;
        $validFields += $this->validateFirstName();
        $validFields += $this->validateLastName();
        $validFields += $this->validatePhone();
        $validFields += $this->validateSinNumber();
        return ($validFields == 4);
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
}