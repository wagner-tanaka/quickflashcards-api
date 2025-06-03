pipeline {
    agent any

    stages {
        stage('Verificar por palavra proibida') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'a7875a37-e804-4ab6-82ff-c36b2402640b',
                        usernameVariable: 'GIT_USER',
                        passwordVariable: 'GIT_TOKEN'
                    )
                ]) {
                    script {
                        sh '''
                            git config --global credential.helper store
                            echo "https://${GIT_USER}:${GIT_TOKEN}@github.com" > ~/.git-credentials

                            git fetch origin main:main
                            git diff main...HEAD > changes.diff

                            awk '
                                /^\+\+\+ b\// { current_file = substr($0, 7) }
                                /^\+.*foobarbaz/ { print current_file ":" $0 }
                            ' changes.diff > resultado.txt
                        '''

                        def resultado = readFile('resultado.txt').trim()

                        if (resultado) {
                            echo "\u001B[31m❌ Palavra proibida 'foobarbaz' encontrada nas seguintes linhas:\n${resultado}\u001B[0m"
                            currentBuild.displayName = "#${env.BUILD_NUMBER} ❌ Palavra proibida"
                            error("Palavra proibida encontrada no PR. Veja detalhes acima.")
                        } else {
                            echo "✅ Nenhuma palavra proibida encontrada."
                        }
                    }
                }
            }
        }
    }
}
