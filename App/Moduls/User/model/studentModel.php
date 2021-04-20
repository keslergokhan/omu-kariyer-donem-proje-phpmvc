
<?php 
class studentModel extends Model
{

    public function profileModel($studentNickName,$id){
        try {
            $control = [];
            $control["student"] = $this->crud->list("student")->where("WHERE student_id=? And deletedata=?",[$id,0])->get("Row");

            if(!empty($control["student"])){
                $control["student_reference"] = $this->crud->list("reference")->where("WHERE student_id = ?",[$control["student"]["student_id"]])->get("All");
                return $control;
            }else{
                throw new Exception("'{$studentNickName}' kullanıcı adında bir öğrenci bulunamadı !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function profileUpdateModel($form){
        try {
            $form["student_id"] = $_SESSION["USER"]["STUDENT"]["student_id"];

            $form["setting"]["width"]=250;

            $control = $this->crud->update("student","student_id",$form);

            if ($control["status"]){
                return helper::catchReturn(1,"?status=1&error=profileUpdate&message={$_SESSION["USER"]["STUDENT"]["student_name"]} {$_SESSION["USER"]["STUDENT"]["student_surname"]} profiliniz güncellendi !");
            }else{
                throw new Exception("?status=0&error=profileUpdate&message=Teknik bir azra oluştu  lütfen daha sonra tekrar deneyin");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

	public function registerAddPModel($form)
	{
        try {
            $controlS = $this->crud->list("student")->where("WHERE student_eposta = ?",[$form["student_eposta"]])->get("Row");
            $controlE = $this->crud->list("employer")->where("WHERE employer_eposta = ?",[$form["student_eposta"]])->get("Row");

            if(empty($controlS) && empty($controlE)){
                $form["setting"]["form_delete"] = "student_passwordcontrol,sozlesme";

                $form["student_nickname"] = $form["student_name"].$form["student_surname"];
                $form["setting"]["seo"] = "student_nickname";

                $control = $this->crud->add("student",$form);
                if($control["status"]){
                    return helper::catchReturn(1,"error=studentRegis&message=<i class='far fa-check-circle'></i> {$form["student_name"]} {$form["student_surname"]} aramıza hoş geldin !");
                }else{
                    throw new Exception(0,"error=studentRegis&&message=<i class='fas fa-exclamation-triangle'></i> {$form["employer_name"]} {$form["employer_surname"]} bir problem oluştu lütfen daha sonra tekrar dene !");
                }
            }else{
                throw new Exception("error=employerRegister&&message=<i class='fas fa-exclamation-triangle'></i> {$form["employer_name"]} {$form["employer_surname"]} kayıt olmak istediğiniz '{$form["employer_eposta"]}' zaten kayıtlı !");
            }
        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }

	}

	public function referenceAddPModel($form){
        try {

            $form["student_id"] = $_SESSION["USER"]["STUDENT"]["student_id"];
            $control = $this->crud->add("reference",$form);

            if($control["status"]){
                return helper::catchReturn(1,"?status=1&error=studentReference&message= <i class='far fa-check-circle'></i> Referansınız eklendi ");
            }else{
                throw new Exception(0,"error=studentRegis&error=studentReference&message=<i class='fas fa-exclamation-triangle'></i> Bir problem oluştu lütfen daha sonra tekrar dene !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

}
			