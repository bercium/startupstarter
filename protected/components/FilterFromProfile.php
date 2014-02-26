<?php

class FilterFromProfile {
	
	public function search($type, $user_id){

		$sqlbuilder = new SqlBuilder;
		$user_id = array( 'user_id' => $user_id);
    
		if($type == 'userByProject'){
			$data = $sqlbuilder->load_array("user", $user_id, "idea,candidate,collabpref,skillset");

			//search user's ideas and generate candidate profile
			if(isset($data['idea']) && count($data['idea'] > 0)){
			foreach($data['idea'] AS $key => $idea){

				if(isset($idea['candidate']) && count($idea['candidate']) > 0){
				foreach($idea['candidate'] AS $key1 => $candidate){

					if(strlen($candidate['available']) > 0) 
						$filter['available'][$candidate['available']] = $candidate['available'];

					if(strlen($candidate['city']) > 0) 
						$filter['city'][$candidate['city']] = $candidate['city'];

					if(isset($candidate['collabpref']) && count($candidate['collabpref']) > 0){
					foreach($candidate['collabpref'] AS $key2 => $collabpref){
						
						if(strlen($collabpref['collab_id']) > 0)
							$filter['collabpref'][$collabpref['collab_id']] = $collabpref['collab_id'];
					}
					}
					
					if(isset($candidate['skillset']) && count($candidate['skillset']) > 0){
					foreach($candidate['skillset'] AS $key2 => $skillset){

						//if(strlen($skillset['skillset']) > 0)
							$filter['skill'][$skillset['skillset']] = $skillset['skillset'];

						if(isset($skillset['skill']) && count($skillset['skill']) > 0){
						foreach($skillset['skill'] AS $key2 => $skill){
							//if(strlen($skill['skill']) > 0)
								$filter['skill'][$skill['skill']] = $skill['skill'];
						}
						}
					}
					}
				}
				}

			}
			}

			//group by same value
			foreach($filter AS $key => $results){
				$filter[$key] = implode(", ", $results);
			}

			return $filter;

		} elseif($type == 'ideaByProfile'){
			$data = $sqlbuilder->load_array("user", $user_id, "collabpref,skillset");

			if(isset($data['available']) && $data['available'] > 0){
				$filter['available'][] = $data['available'];
			}

			if(isset($data['collabpref']) && count($data['collabpref']) > 0){
			foreach($data['collabpref'] AS $key => $collabpref){
				
				if(strlen($collabpref['active']) > 0)
					$filter['collabpref'][$collabpref['active']] = $collabpref['active'];
			}
			}
			
			if(isset($data['skillset']) && count($data['skillset']) > 0){
			foreach($data['skillset'] AS $key => $skillset){

				if(strlen($skillset['skillset']) > 0)
					$filter['skill'][$skillset['skillset']] = $skillset['skillset'];

				if(isset($skillset['skill']) && count($skillset['skill']) > 0){
				foreach($skillset['skill'] AS $key1 => $skill){
					if(strlen($skill['skill']) > 0)
						$filter['skill'][$skill['skill']] = $skill['skill'];
				}
				}
			}
			}

			//group by same value
			foreach($filter AS $key => $results){
				$filter[$key] = implode(", ", $results);
			}

			return $filter;

		}
	}
}

?>