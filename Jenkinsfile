pipeline {
    agent any

    stages {
        stage('Check for forbidden word in additions') {
            steps {
                script {
                    def forbiddenWord = "foobarbaz"

                    withCredentials([usernamePassword(credentialsId: 'github-credentials', usernameVariable: 'GIT_USERNAME', passwordVariable: 'GIT_PASSWORD')]) {
                        sh "git config --global credential.helper store"
                        sh """
                            git config --global user.email "jenkins@example.com"
                            git config --global user.name "jenkins"
                            git remote set-url origin https://${GIT_USERNAME}:${GIT_PASSWORD}@github.com/wagner-tanaka/quickflashcards-api.git
                            git fetch origin main
                        """
                        def diff = sh(script: "git diff origin/main...HEAD", returnStdout: true)

                        def currentFile = ''
                        def lineNum = 0

                        diff.split('\n').each { line ->
                            if (line.startsWith('+++ b/')) {
                                currentFile = line.replace('+++ b/', '').trim()
                            } else if (line.startsWith('@@')) {
                                def matcher = line =~ /@@ \-(\\d+),?\\d* \\+(\\d+),?(\\d*) @@/
                                if (matcher) {
                                    lineNum = matcher[0][2].toInteger() - 1
                                }
                            } else if (line.startsWith('+') && !line.startsWith('+++')) {
                                lineNum++
                                def content = line.substring(1)
                                if (content.contains(forbiddenWord)) {
                                    echo "❌ Palavra proibidas '${forbiddenWord}' em ${currentFile}, linha ${lineNum}: ${content.trim()}"
                                }
                            } else if (!line.startsWith('-')) {
                                lineNum++
                            }
                        }
                    }
                }
            }
        }
    }
}
