<!DOCTYPE html>
<html>
	<head>
		<title>Task_02</title>
		<meta charset="UTF-8">
		<style>	
		
			form, .result {
				width: 250px;
				margin: 25px auto;
			}
			
			input {
				margin: 5px 0;
				width: 100%;
			}
			input[type="submit"] {
				margin-top: 15px;
				width: 100%;
			}
			
			table, th, td {
			    border: 1px solid black;
			    text-align: center;
			    color: black;
			}
			
			th, td {
			    padding: 10px;
			}
									
		</style>
	</head>
	<body>		                                                 
		
		<form action="#" method="post">
			Query: <input type="text" name="query">
			<input type="submit">
		</form>		
		
		<div class="result">
		<p>Result:</p>
			<?php
			
				if($_POST && $_POST["query"]){			
				
					$data = array();
					$filepointer = fopen("task_02.csv", "r");			
					$header = fgetcsv($filepointer);			
					while($row = fgetcsv($filepointer)) {				
						$data[] = array_combine($header, $row);
					}
					
					/*echo "<pre>";
					print_r($data);
					echo "</pre>";*/		
					 
					function getQueryResult($query, $keys, $limit=0, $string=''){          // $result = getQueryResult($command, array(), $limit, $query[1]);     
						
						 
						global $data;
						global $header;
						$result = null;
						if($limit == 0 || $limit > count($data)){
							$limit = count($data);
						}
						switch($query){
							case 'show':
								$result = implode(', ', $header);
								break;
							case 'select':
								$result = array();				
								for ($i=0; $i<$limit; $i++) {							
									$item = getSelectResult($keys, $data[$i]);
									if(count($item) > 0){
										$result[] = $item;
									}
								}
								break;					
							case 'sum':
								$result = getSumResult($keys, $limit);
								break;
							break;	
							case 'find':						
								$result = getFindResult($string, $limit);
							break;
							default: 
								$result = "Don't crash the program.";
						}
						
						return $result;
						
					}
					
					function getSelectResult($keys, $data){                           
						$result = array();
						foreach ($keys as $key) {
							$key = strtolower($key);
							if(array_key_exists($key, $data)){
								$result[$key] = $data[$key];
							}
						}
						return $result;
						
					}
					
					function getSumResult($keys, $limit){
						
						global $data;
						$result = array();
						foreach ($keys as $key) {
							$sum = 0;
							for ($i=0; $i<$limit; $i++) {
								if(array_key_exists($key, $data[$i]) && is_numeric($data[$i][$key])){
									$sum += (int) $data[$i][$key];
								}						
							}
							if($sum > 0){
								$result[] = array($key =>$sum);
							}
						}
						return $result;
						
					}
					
					function getFindResult($string, $limit){
						
						global $data;
						$string = str_replace('"', "", $string);						
						$result = array();
						$string = strtolower($string);
						for ($i=0; $i<$limit; $i++) {					
							foreach ($data[$i] as $key => $value) {
								if(preg_match("/$string/i", $value)){
									$result[] = $data[$i];
									break;
								}
							}
						}
						return $result;
						
					}			
					
					/*$result = getQueryResult('show');
					var_dump($result);
					echo "<br/><br/>";
					$result = getQueryResult('select', array('id'));
					var_dump($result);
					echo "<br/><br/>";
					$result = getQueryResult('select', array('id', 'name'));
					var_dump($result);
					echo "<br/><br/>";
					$result = getQueryResult('select', array('id', 'name'), 2);
					var_dump($result);
					echo "<br/><br/>";
					$result = getQueryResult('sum', array('id'));
					var_dump($result);
					$result = getQueryResult('find', array(), 0, "-");
					var_dump($result);*/
					
					$post = strtolower($_POST["query"]);
					$post = trim(preg_replace("/query>/i", "", $post));
					$post = preg_replace("/,/", "", $post);
					$query = explode(" ", $post);
					$limit = 0;
					$command = $query[0];
					if(preg_match("/find/i", $command)){
						$result = getQueryResult($command, array(), $limit, $query[1]);
					}
					else {
						$columns = array();
						$limit_index = array_search("limit", $query);
						if($limit_index !== false && $limit_index >= 0){
							$limit = $query[$limit_index + 1];
							$columns = array_slice($query, 1, $limit_index - 1);
						}
						else {
							$columns = array_slice($query, 1);
						}
						$result = getQueryResult($query[0], $columns, $limit);	
					}
					
					if(is_array($result) && count($result) > 0){
						echo '<table><thead><tr>';
						foreach ($result[0] as $key => $value) {
							echo '<th>' . $key . '</th>';
						}
						echo '</tr></thead><tbody>';
						for ($i=0; $i<count($result); $i++) {
							echo '<tr>';			
							foreach ($result[$i] as $key => $value) {
								echo '<td>' . $value . '</td>';
							}
							echo '</tr>';
						}
						echo '</tbody></table>';
					}
					elseif(!is_array($result)) {
						echo $result;
					}
					else {
						echo "No results found!";
					}					
				}
				
			?>
		</div>
	</body>
</html>