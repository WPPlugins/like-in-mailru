			jQuery(document).ready(function() {

				
				$('#likemailru_send_thank_btn').click(function() {
					$.ajax(
						"http://feedback.bogutsky.ru/public/addthank",
						{
							dataType: 'jsonp',
							data: {project: 'likemailru', url: $('#likemailru_send_url').val(),email: $('#likemailru_send_email').val()},
							success: function(response) {
								alert(response.status);
							}
						}
					);
				});
				
				$('#likemailru_show_responseform').click(function() {
					
					$('#likemailru_responseform').toggle('500');
				});
				
				$('#likemailru_send_response_btn').click(function() {
					if($('#likemailru_send_response').val() != '')
						$.ajax(
							"http://feedback.bogutsky.ru/public/addresponse",
							{
								dataType: 'jsonp',
								data: {project: 'likemailru', response: $('#likemailru_send_response').val(), url: $('#likemailru_send_url').val(),email: $('#likemailru_send_email').val()},
								success: function(response) {
									alert(response.status);
								}
							}
						);
					else
						alert('Сообщение не введено! \n Message is empty!');
				});				
				
				

			});