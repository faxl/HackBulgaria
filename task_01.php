<!DOCTYPE html>
<html>
	<head>
		<title>Task_01</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<p>PHP Result:</p>
		<?php
		
			function maskOutWords($words, $text) {
				foreach ($words as $key => $value){
					$text = preg_replace("/$value/i", str_repeat('*', strlen($value)), $text);
				}
				return $text;
			}
			
			$text = 'Yesteday, I took my dog for a walk.\n It was crazy! My dog wanted only food.';
			$words = array("yesteday", "Dog", "food", "walk");		
			$result = maskOutWords($words, $text);
			echo($result);
		
		?>
		
		<p>JS Result:</p>
		<p id="js-result"></p>
		
		<script>
		
			function maskOutWords(words, text) {
				for(var i=0;i<words.length;++i){
					var word = words[i];
					var regexp = new RegExp(word, 'i');
					text = text.replace(regexp, strRepeat('*', word.length), text);
				}
				return text;				
			}
			
			function strRepeat(input, multiplier) {
				  var y = '';
				  while (true) {
				    if (multiplier & 1) {
				      y += input;
				    }
				    multiplier >>= 1;
				    if (multiplier) {
				      input += input;
				    } else {
				      break;
				    }
				  }
				  return y;
			}
			
			var words = ["yesteday", "Dog", "food", "walk"];
			var text =  "Yesteday, I took my dog for a walk.\\n It was crazy! My dog wanted only food.";
			var result = maskOutWords(words, text);
			document.getElementById("js-result").innerHTML = result;
			
		</script>
	</body>
</html>