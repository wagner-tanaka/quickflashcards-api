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
                        # Generate the diff and store it in a file
                        git diff main...HEAD > changes.diff

                        echo "Linhas adicionadas no PR com 'foobarbaz':"
                        # Use awk to find filenames and matching lines
                        awk '\
                          /^\+\+\+ b\// { current_file=substr($2, 3) } \
                          /^\+.*foobarbaz/ { if (current_file) print current_file ": " $0 } \
                        ' changes.diff > found_lines.txt

                        # Check if any matching lines were found
                        if [ -s found_lines.txt ]; then
                            cat found_lines.txt
                        else
                            echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."
                        fi
                    '''
                }
            }
        }
    }
}
