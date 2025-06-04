pipeline {
    agent any

    stages {
        stage('Mostrar linhas adicionadas no PR e analisar com AI') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'e92cb10e-0dd1-4142-a0fb-29a9488e3116',
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
                        /^\\+\\+\\+ b\\// { current_file = substr($0, 7) }
                        /^\\+.*foobarbaz/ { print current_file ":" $0 }
                        ' changes.diff || echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."

                        echo "Enviando alterações para análise pela IA local..."

                        PROMPT=$(jq -Rs . < changes.diff)

                        JSON=$(jq -n --arg prompt "Leia o seguinte diff e identifique palavras escritas incorretamente em inglês:\\n" --arg diff "$PROMPT" --arg model "gemma3:1b" '{
                            model: $model,
                            prompt: ($prompt + $diff),
                            stream: false
                        }')

                        AI_RESPONSE=$(curl -s http://host.docker.internal:11434/api/generate -d "$JSON" | jq -r .response)

                        echo "Resposta da IA:"
                        echo "$AI_RESPONSE"
                    '''
                }
            }
        }
    }
}
