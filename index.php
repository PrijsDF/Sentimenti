<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		
		<!-- jQuery -->
		<script src="jquery/jquery-3.6.0.min.js"></script>

		<!-- For reading CSVs -->
		<script src="jquery/jquery.csv.js"></script>
		<script src="js/papaparse.min.js"></script>

		<title>SentiMenti</title>
	</head>
	<body class="text-center">
			<div class="container">
				<!-- text row -->
				<div id="text_row" class="row">
					<!-- text -->
					<h1 id="text">It looks like all texts were labeled!</h1>
				</div>
			</div>
				
			<div id="senti_scores_container" class="container-fluid">
				<!-- Sentiment scores row -->
				<div id="senti_scores_row" class="row justify-content-center">
					<!-- 1 -->
					<div class="col-md-1">
						<button id="s_score_1" type="button" class="knop btn btn-outline-light">1</button>
					</div>
					<!-- 2 -->
					<div class="col-md-1">
						<button id="s_score_2" type="button" class="knop btn btn-outline-light">2</button>
					</div>
					<!-- 3 -->
					<div class="col-md-1">
						<button id="s_score_3" type="button" class="knop btn btn-outline-light">3</button>
					</div>
					<!-- 4 -->
					<div class="col-md-1">
						<button id="s_score_4" type="button" class="knop btn btn-outline-light">4</button>
					</div>
					<!-- 5 -->
					<div class="col-md-1">
						<button id="s_score_5" type="button" class="knop btn btn-outline-light">5</button>
					</div>
					<!-- 6 -->
					<div class="col-md-1">
						<button id="s_score_6" type="button" class="knop btn btn-outline-light">6</button>
					</div>
					<!-- 7 -->
					<div class="col-md-1">
						<button id="s_score_7" type="button" class="knop btn btn-outline-light">7</button>
					</div>
					<!-- 8 -->
					<div class="col-md-1">
						<button id="s_score_8" type="button" class="knop btn btn-outline-light">8</button>
					</div>
					<!-- 9 -->
					<div class="col-md-1">
						<button id="s_score_9" type="button" class="knop btn btn-outline-light">9</button>
					</div>
				</div>
			</div>
			
			<div id="counter_container" class="container-fluid">
				<!-- Sentiment scores row -->
				<div id="counter_row" class="row justify-content-center">
					<div class="col-md-2">
						<p id="counter">...</p>
					</div>
				</div>
			</div>
		
		<!-- Bootstrap JS-->
		<script src="js/bootstrap.bundle.min.js"></script>
		
		<!-- Load texts into memory  -->
		<script>
			var data = []
			function read_data() {
				// Parse local CSV file
				$.get('data.csv', function(CSVdata) {
					// NOTE: If there is a newline at the end of the csv file, the counters will be off due to the newline being added as an empty data row,
					// and therefore not being picked up in the previous loop as it does not contain any sentiment score 
					// We skip newlines in the file with the skipEmptyLines config
					Papa.parse(CSVdata, {
						skipEmptyLines: true,
						complete: function(results) {
							data = results.data;
							
							header = data[0];
							data_rows = data.slice(1, data.length);
							
							// Shuffle the data
							for(let i = data_rows.length - 1; i > 0; i--){
								const j = Math.floor(Math.random() * i);
								const temp = data_rows[i];
								data_rows[i] = data_rows[j];
								data_rows[j] = temp;
							}
							
							// Create array with texts that have not been labeled yet
							data_to_label = []
							for (const text of data_rows){
								if (text[0] == 99) {
									data_to_label.push(text); 
								}
							}
							
							// These numbers are shown as a counter
							total_length = data_rows.length;
							labeled_length = total_length - data_to_label.length;
							
							// Update the counter
							if (data_to_label.length != 0){
								$('#counter').text(String(labeled_length+1) + '/' + String(total_length));
								
								label_this_text = data_to_label.shift();
								$('#text').text(label_this_text[1]);
							} else{
								$('#counter').text('All texts labeled');
								$('#text').text('All texts labeled!');
							}
						}
					});
				});
			}
		
			$(document).ready(function() {
				// Without this line, the script will often fetch a cached version of the dataset
				$.ajaxSetup({ cache: false });
				
				read_data();
				
				$('button').click(function(){
					var sentiment_given = $(this).attr('id').slice(-1);
					
					// Change the texts label to the given sentiment score
					for(i = 0; i < data_rows.length; i++){
						if(data_rows[i].includes(label_this_text[0])){
							// Update the label
							data_rows[i][0] = sentiment_given;
						}
					}
					
					// Put the array back together; we merge the header + data_rows (which includes the newly labeled text)
					data = [];
					data = data.concat([header]).concat(data_rows);
					
					// Save the updated data 
					$.ajax({
						cache: false,
						url: "write_data.php",
						type: "POST",
						data: {texts: JSON.stringify(data)},
						success: function(response){
							read_data();
						}
				   });
				});
			});
		</script>
	</body>
</html>