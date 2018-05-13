<?php

class FilterFromProfile {
	
	public function search($type, $user_id){

		$sqlbuilder = new SqlBuilder;
		$user_id = array( 'user_id' => $user_id);
    
		if($type == 'userByProject'){
			$data = $sqlbuilder->load_array("user", $user_id, "idea,member,candidate,collabpref,skill,industry");

			//don't show me
			$filter['exclude'][$user_id['user_id']] = $user_id['user_id'];
			//don't show people from my projects
			if(isset($data['idea']) && count($data['idea'] > 0)){
			foreach($data['idea'] AS $key => $idea){
				if(isset($idea['member']) && count($idea['member']) > 0){
				foreach($idea['member'] AS $key1 => $member){
					$filter['exclude'][$member['id']] = $member['id'];
				}
				}
			}
			}

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
					
					if(isset($candidate['skill']) && count($candidate['skill']) > 0){
					foreach($candidate['skill'] AS $key2 => $skill){

						if(strlen($skill['skill']) > 0)
							$filter['skill'][$skill['skill']] = $skill['skill'];

					}
					}

					if(isset($industry['industry']) && count($industry['industry']) > 0){
					foreach($industry['industry'] AS $key2 => $industry){

						if(strlen($industry['industry']) > 0)
							$filter['industry'][$industry['industry']] = $industry['industry'];

					}
					}
				}
				}

			}
			}

			//group by same value
			foreach($filter AS $key => $results){
				if($key != 'exclude'){
					$filter[$key] = implode(", ", $results);
				}
			}

			return $filter;

		} elseif($type == 'ideaByProfile'){
			$data = $sqlbuilder->load_array("user", $user_id, "collabpref,skill,industry,idea,");

			//exclude ideas that user is member of
			if(isset($data['idea']) && count($data['idea']) > 0){
			foreach($data['idea'] AS $key => $idea){
				$filter['exclude'][] = $idea['id'];
			}
			}

			if(isset($data['available']) && $data['available'] > 0){
				$filter['available'][] = $data['available'];
			}

			if(isset($data['collabpref']) && count($data['collabpref']) > 0){
			foreach($data['collabpref'] AS $key => $collabpref){
				
				if(strlen($collabpref['active']) > 0)
					$filter['collabpref'][$collabpref['active']] = $collabpref['active'];
			}
			}
			
			if(isset($data['skill']) && count($data['skill']) > 0){
			foreach($data['skill'] AS $key => $skill){

				if(strlen($skill['skill']) > 0)
					$filter['skill'][$skill['skill']] = $skill['skill'];
			}
			}

			if(isset($data['industry']) && count($data['industry']) > 0){
			foreach($data['industry'] AS $key => $industry){

				if(strlen($industry['industry']) > 0)
					$filter['industry'][$industry['industry']] = $industry['industry'];
			}
			}

			//group by same value
			foreach($filter AS $key => $results){
				if($key != 'exclude'){
					$filter[$key] = implode(", ", $results);
				}
			}

			return $filter;

		}
	}
}

?>