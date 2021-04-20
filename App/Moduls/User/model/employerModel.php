
<?php 
class employerModel extends Model
{
    public function employerProfileUpdatePModel($form){
        try {
            helper::array_pre($form);

            $_POST = helper::emptyControl($form);

            $form["employer_id"] = $_SESSION["USER"]["EMPLOYER"]["employer_id"];
            $form["employer_nickname"] = $form["employer_name"].$form["employer_surname"];
            $form["setting"]["seo"] = "employer_nickname";
            $form["setting"]["file_name_input"] = "employer_nickname";
            $form["setting"]["delete_file"] = $_SESSION["USER"]["EMPLOYER"]["employer_img"];
            $form["setting"]["width"]=250;

            $control = $this->crud->update("employer","employer_id",$form);

            if($control["status"]){
                $_SESSION["USER"]["EMPLOYER"] = $this->crud->list("employer")->where("WHERE employer_id = ?",[$_SESSION["USER"]["EMPLOYER"]["employer_id"]])->get("Row");
                return helper::catchReturn(1,"?status=1&error=profileUpdate&message=<i class='far fa-check-circle'></i> Profil güncellendi");
            }else{
                throw new Exception("?status=0&error=profileUpdate&message=<i class='fas fa-exclamation-triangle'></i> Bir problem oluştu lütfen daha sonra tekrar deneyin !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

	public function profileModel($employerNickName,$id)
	{
        try {
            $control = [];
            $control["employer"] = $this->crud->list("employer")->where("WHERE employer_id=? And deletedata=?",[$id,0])->get("Row");

            if(!empty($control["employer"])){
                $control["adverties"] = $this->crud->list("adverties")->where("WHERE employer_id = ?",[$id])->get("All");
                return $control;
            }else{
                throw new Exception("'{$employerNickName}' kullanıcı adında bir şirket bulunamadı !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
	}

	public function registerAddPModel($form){
	    //Gelen e-posta zaten kayıtlımı kontorl ettik

        try {

            $controlS = $this->crud->list("student")->where("WHERE student_eposta = ?",[$form["employer_eposta"]])->get("Row");
            $controlE = $this->crud->list("employer")->where("WHERE employer_eposta = ?",[$form["employer_eposta"]])->get("Row");

            if(empty($controlS) && empty($controlE)){
                //Input ile gelen sözleşmeyi ve şifre kontrol sildik
                $form["setting"]["form_delete"] = "employer_passwordcontrol,sozlesme";

                //Ad ve soyad ile nickname oluşturduk
                $form["employer_nickname"] = $form["employer_name"].$form["employer_surname"];
                $form["setting"]["seo"] = "employer_nickname";

                $control = $this->crud->add("employer",$form);
                if($control["status"]){
                    return helper::catchReturn(1,"error=employerRegister&message=<i class='far fa-check-circle'></i> {$form["employer_name"]} {$form["employer_surname"]} aramıza hoş geldin !");
                }else{
                    throw new Exception("error=employerRegister&&message=<i class='fas fa-exclamation-triangle'></i> {$form["employer_name"]} {$form["employer_surname"]} bir problem oluştu lütfen daha sonra tekrar dene !");
                }
            }else{
                throw new Exception("error=employerRegister&&message=<i class='fas fa-exclamation-triangle'></i> {$form["employer_name"]} {$form["employer_surname"]} kayıt olmak istediğiniz '{$form["employer_eposta"]}' zaten kayıtlı !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }

    }

    public function advertiesAddPModel($form){
        try {

            $form["employer_id"] = $_SESSION["USER"]["EMPLOYER"]["employer_id"];
            $form = helper::trimControl($form);
            $form["adverties_date"] = date("d-m-Y");
            $control = $this->crud->add("adverties",$form);

            if($control["status"]){
                return helper::catchReturn(1,"?status=1&error=add&message=<i class='far fa-check-circle'></i> İlanınız eklendi  <br> Eklemiş olduğunuz ilanlara bakmak için profilinizi ziyaret edebilirsiniz !");
            }else{
                throw new Exception("?status=0&error=add&message=Teknik bir arza oluştu lütfen daha sonra tekrar deneyin !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function advertiesUpdateModel($id){
        try {
            $data = [];

            $data["adverties"] = $this->crud->list("adverties")->where("WHERE adverties_id = ? AND employer_id = ?",[$id,$_SESSION["USER"]["EMPLOYER"]["employer_id"]])->get("Row");

            if(!empty($data["adverties"])){
                return $data;
            }else{
                return helper::catchReturn(0,"?status=0&error=update&message= Teknik bir problem oluştu lütfen daha sonra tekrar deneyin");
            }
        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function advertiesUpdatePModel($form){
        try {

            $form["adverties_date"] = date("d-m-Y");
            $data = $this->crud->update("adverties","adverties_id",$form);

            if($data["status"]){
                return helper::catchReturn(1,"/{$form["adverties_id"]}?status=1&error=update&message=<i class='far fa-check-circle'></i> İlan güncellendi !");
            }else{
                return helper::catchReturn(0,"/{$form["adverties_id"]}status=0&error=update&message=Teknik bir arza oluştu lütfen daha sonra tekrar deneyin !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function advertiesRemove($id){
        try {

            $data = $this->crud->delete("adverties","adverties_id",$id);

            if($data["status"]){
                return helper::catchReturn(1,"?status=1&error=remove&message=<i class='far fa-check-circle'></i> İlan silindi !");
            }else{
                return helper::catchReturn(0,"?status=0&error=remove&message=Teknik bir arza oluştu lütfen daha sonra tekrar deneyin !");
            }

        }catch (Exception $e){
            return helper::catchReturn(0,$e->getMessage());
        }
    }

}
			