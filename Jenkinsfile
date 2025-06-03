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

                        git fetch origin main:main
                        git diff --unified=0 main...HEAD > changes.diff

                        echo "Buscando linhas com 'foobarbaz' adicionadas no PR..."

                        awk '
                            /^diff --git/ { arquivo=$3; sub("b/", "", arquivo) }
                            /^@@/ {
                                match($0, /\\+([0-9]+)/, m)
                                linha=m[1]-1
                            }
                            /^\\+/ && !/^\\+\\+\\+/ {
                                linha++
                                if ($0 ~ /foobarbaz/) {
                                    printf("Arquivo: %s | Linha: %d | Conteúdo: %s\\n", arquivo, linha, substr($0,2))
                                }
                            }
                        ' changes.diff || echo "Nenhuma ocorrência encontrada."
                    '''
                }
            }
        }
    }
}
