<?php

    class SignUpController extends SignUp {
        private string $name;
        private string $surname;
        private string $email;
        private string $pwd;
        private string $rpwd;

        public function __construct(string $name,string $surname,string $email,string $pwd,string $rpwd){
            $this->name=$name;
            $this->surname=$surname;
            $this->email=$email;
            $this->pwd=$pwd;
            $this->rpwd=$rpwd;
        }
        public function SignUpUser(){
            if(!$this->EmptyInput()){
                header("Location: ../index.php?error=emptyinput");
                exit();
            }
            if(!$this->InvalidName()){
                header("Location: ../index.php?error=invalidname");
                exit();
            }
            if(!$this->InvalidEmail()){
                header("Location: ../index.php?error=invalidemail");
                exit();
            }
            if(!$this->InvalidPassword()){
                header("Location: ../index.php?error=invalidepassword");
                exit();
            }

            if(!$this->checkExistenceName()){
                header("Location: ../index.php?error=nametaken");
                exit();
            }
            if(!$this->checkExistenceEmail()){
                header("Location: ../index.php?error=emailtaken");
                exit();
            }
            $this->SetUser($this->name,$this->surname,$this->email,$this->pwd);
        }
        private function EmptyInput(){
            $result = true;
            if(empty($this->name) || empty($this->surname) || empty($this->email) || empty($this->pwd) || empty($this->rpwd)){
                $result = false;
            }
            return $result;
        }
        private function InvalidName(){
            $result = true;
            if(!preg_match("/^[a-zA-Z0-9]*$/",$this->name)){
                $result = false;
            }
            return $result;
        }
        private function InvalidEmail(){
            $result = true;
            if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                $result = false;
            }
            return $result;
        }
        private function InvalidPassword(){
            $result = true;
            if($this->pwd!==$this->rpwd){
                $result = false;
            }
            return $result;
        }

        private function checkExistenceEmail(){
            $result = true;
            if(!$this->checkEmail($this->email)){
                $result = false;
            }
            return $result;
        }
        private function checkExistenceName(){
            $result = true;
            if(!$this->checkName($this->name)){
                $result = false;
            }
            return $result;
        }
    }
?>
