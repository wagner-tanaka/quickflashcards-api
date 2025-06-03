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
                          # Cada vez que o diff mostra o cabeçalho "diff --git a/xxx b/xxx", pega
                          # o nome do arquivo (parte depois de "a/").
                          /^diff --git a\\/.+ b\\// {
                              split($0, parts, " ");
                              # parts[2] = "a/path/to/file"
                              sub("^a/", "", parts[2]);
                              filename = parts[2];
                          }
                          # Alternativamente, você pode usar o "+++ b/..." em vez de "diff --git"
                          #/^\\+\\+\\+ b\\// {
                          #    sub("^\\+\\+\\+ b/", "", $0);
                          #    filename = $0;
                          #}
                          # Para cada linha adicionada que contém "foobarbaz", imprime "arquivo: linha"
                          /^\+.*foobarbaz/ {
                              # substr($0,2) remove o caráter '+' do diff para só mostrar o código
                              print filename ":" substr($0, 2)
                          }
                        ' changes.diff || echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."
                    '''
                }
            }
        }
    }
}
