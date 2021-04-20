<?php
class HomeModel extends Model
{

	public function indexModel()
	{	
		$data = [];
		$data["adverties"] = $this->crud->list("adverties")->where("ORDER BY adverties_date DESC")->get("All");
        foreach ($data["adverties"] as $index => $adv){ //Her ilanın sahibini çekiyoruz
            $data["adverties"][$index]["employer"] = $this->crud->column("employer","employer_company,employer_img")
                ->where("WHERE employer_id=?",[$adv["employer_id"]])->get("Row");
        }

        $data["student"] = $this->crud->list("student")->exec()->get("All");
		return $data;
	}

	public function advertiesModel($id){
        $data = [];
        $data["adverties"] = $this->crud->list("adverties")->where("WHERE adverties_id = ?",[$id])->get("Row");

        $data["adverties_all"] = $this->crud->list("adverties")->where("WHERE adverties_id != ?",[$id])->get("All");
        foreach ($data["adverties_all"] as $index => $adv){// Her ilanın sahibini çekiyoruz
            $data["adverties_all"][$index]["employer"] = $this->crud->column("employer","employer_company,employer_img")
                ->where("WHERE employer_id=?",[$adv["employer_id"]])->get("Row");
        }

        if(!empty($data["adverties"])){
            $data["employer"] = $this->crud->list("employer")->where("WHERE employer_id =?",[$data["adverties"]["employer_id"]])->get("Row");
            return $data;
        }else{
            return false;
        }

    }

    public function AdvertiesSearchListModel($page,$key){
	    $data = [];
	    $data["adverties"] = $this->crud->list("adverties")->where("WHERE adverties_title LIKE ?",[$key])->get("All");

	    if(count($data["adverties"]) > 0 || !empty($data["adverties"])){
            foreach ($data["adverties"] as $index => $adv){ //Her ilanın sahibini çekiyoruz
                $data["adverties"][$index]["employer"] = $this->crud->column("employer","employer_company,employer_img")
                    ->where("WHERE employer_id=?",[$adv["employer_id"]])->get("Row");
            }
        }
        return $data;
    }

}
			