pipeline {  

	agent any

		environment {    
			versionZbx = "release/4.2"
			registryZbx = "begun74/zabbix-project:v$versionZbx"        
			registryCredential = 'dockerhub'        
			DB_HOST = "mysql-zabbix"    
			DB_USER = "zabbix"    
			DB_PASS = "zabbix"    
			DB_NAME = "zabbix"  
		}  
		stages {    
			stage('Cloning Git zabbix') {      
				steps {         
					sh "rm -rf *"        
					git branch: 'release/4.2' , url: 'git@github.com:begun74/zabbix.git'        
					//git git@github.com:begun74/zabbix.git'      
				}    
			}    
			stage('Building image docker-xwiki') {      
				steps{        
					script {            
						sh 'ls -la'            
									

						//dockerImage = docker.build registryZbx        
					}      
				}    
			}     
			stage('Deploy Image  docker-xwiki') {      
				steps{        
					script {          
						docker.withRegistry( '', registryCredential ) {            
							//dockerImage.push()          
						}        
					}      
				}    
			}    
			stage('Remove Unused docker image  zabbix') {      
				steps{                
					//sh "docker rmi $registryZbx"        
					//sh "docker images"      
				}    
			}  
		}      
		post {            
			success {                
				slackSend (channel: '#jenkins_news',color: '#00FF00', message: "SUCCESSFUL: Job '${env.JOB_NAME} [$docker-xwiki $versionXwiki]' (${env.BUILD_URL})")            
				
				sh """
				   export ${env.API_AUTH_HEADER}='bvv:11060553e483551f3cf0cf497f629b03c4'
				   curl -X POST -u ${env.API_AUTH_HEADER} http://jenkins.local/view/SA/job/02.Docker-xwiki.sa-project/build
				"""
			}            
			failure {                
				slackSend (channel: '#jenkins_news',color: '#FF0000', message: "FAILED: Job '${env.JOB_NAME} [$docker-xwiki $versionXwiki]' (${env.BUILD_URL})")            
			}        
		}
}
