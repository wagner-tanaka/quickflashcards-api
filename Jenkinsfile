pipeline {
    agent any

    stages {
        stage('Check for forbidden word in additions') {
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

                        # Buscar o branch main remoto e criar como branch local
                        git fetch origin main:main

                        # Verificar diferença com o main
                        git diff main...HEAD > changes.diff

                        echo "Linhas adicionadas no PR com 'foobarbaz':"
                        grep '^+.*foobarbaz' changes.diff || echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."
                    '''
                }
            }
        }
    }
}
