pipeline {
    agent any

    stages {
        stage('Mostrar linhas adicionadas no PR') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'a7875a37-e804-4ab6-82ff-c36b2402640b',
                        usernameVariable: 'GIT_USER',
                        passwordVariable: 'GIT_TOKEN'
                    )
                ]) {
                    sh '''
                        git config --global credential.helper store
                        echo "https://${GIT_USER}:${GIT_TOKEN}@github.com" > ~/.git-credentials

                        git fetch origin main:main

                        echo "Linhas adicionadas no PR:"

                        git diff --unified=0 main...HEAD | awk '
                            /^diff --git/ {
                                split($3, path, "b/")
                                file = path[2]
                            }
                            /^@@/ {
                                match($0, /\+([0-9]+)/, m)
                                line = m[1]
                            }
                            /^\+/ && !/^\+\+\+/ {
                                printf("Arquivo: %s | Linha: %d | %s\n", file, line, substr($0, 2))
                                line++
                            }
                        '
                    '''
                }
            }
        }
    }
}
