
<?php 
class userModel extends Model
{

	public function userLoginPModel($form)
	{
        try {

            $student = $this->crud->list("student")->where("WHERE student_eposta = ? AND student_password = ?",[$form["userEposta"],$form["userPassword"]])->get("Row");
            $employer = $this->crud->list("employer")->where("WHERE employer_eposta = ? AND employer_password = ?",[$form["userEposta"],$form["userPassword"]])->get("Row");

            if(!empty($student)){
                if(isset($_SESSION["USER"])) unset($_SESSION["USER"]);
                $_SESSION["USER"]["STUDENT"] = $student;
                return helper::catchReturn(1,"?user=student");
            }else if(!empty($employer)){
                if(isset($_SESSION["USER"])) unset($_SESSION["USER"]);
                $_SESSION["USER"]["EMPLOYER"] = $employer;
                return helper::catchReturn(1,"?user=employer");
            }else{
                throw new Exception("?status=0&error=userLogin&message=<i class='fas fa-exclamation-triangle'></i> Hata : {$form["userEposta"]} veya şifre yanlış !");
            }
        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
	}



}
			