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
                        git diff main...HEAD > changes.diff

                        echo "Linhas adicionadas no PR com 'foobarbaz':"
                        awk '
                        /^\\+\\+\\+ b\\// { current_file = substr($0, 7); line_num = 0 }
                        /^@@.*\\+/ {
                            match($0, /\\+([0-9]+)/, arr)
                            if (arr[1]) line_num = arr[1] - 1
                        }
                        /^\\+/ {
                            line_num++
                            if ($0 ~ /foobarbaz/ && $0 !~ /echo.*foobarbaz/ && $0 !~ /grep.*foobarbaz/ && $0 !~ /awk.*foobarbaz/) {
                                print current_file ":" line_num ":" substr($0, 2)
                            }
                        }
                        ' changes.diff || echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."
                    '''
                }
            }
        }
    }
}
