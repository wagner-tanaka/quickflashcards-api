pipeline {
    agent any

    stages {
        stage('Visualizar linhas adicionadas no PR') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'e92cb10e-0dd1-4142-a0fb-29a9488e3116',
                        usernameVariable: 'GIT_USER',
                        passwordVariable: 'GIT_TOKEN'
                    )
                ]) {
                    sh '''
                        echo "🔍 Buscando linhas adicionadas no PR..."

                        git config --global credential.helper store
                        echo "https://${GIT_USER}:${GIT_TOKEN}@github.com" > ~/.git-credentials

                        git fetch origin main:main

                        echo "🆕 Linhas adicionadas neste PR:"

                        # Option 1: Show filename, line number, and content
                        git diff main...HEAD --unified=0 | awk '
                        /^diff --git/ { file = $4; gsub(/^b\//, "", file) }
                        /^@@/ {
                            match($0, /\+([0-9]+)/, arr)
                            line_start = arr[1]
                            line_count = 0
                        }
                        /^\+[^+]/ {
                            line_count++
                            current_line = line_start + line_count - 1
                            content = substr($0, 2)
                            printf "📁 %s:%d | %s\n", file, current_line, content
                        }'

                        echo ""
                        echo "📊 Resumo por arquivo:"

                        # Option 2: Summary by file
                        git diff main...HEAD --numstat | while read added removed file; do
                            if [ "$added" != "-" ] && [ "$added" -gt 0 ]; then
                                echo "📄 $file: +$added linhas adicionadas"
                            fi
                        done

                        # Check if no changes found
                        if [ $(git diff main...HEAD --numstat | wc -l) -eq 0 ]; then
                            echo "Nenhuma linha adicionada encontrada."
                        fi
                    '''
                }
            }
        }
    }
}


// show added lines in pr, missing the file name and changed line
// pipeline {
//     agent any
//
//     stages {
//         stage('Visualizar linhas adicionadas no PR') {
//             steps {
//                 withCredentials([
//                     usernamePassword(
//                         credentialsId: 'e92cb10e-0dd1-4142-a0fb-29a9488e3116',
//                         usernameVariable: 'GIT_USER',
//                         passwordVariable: 'GIT_TOKEN'
//                     )
//                 ]) {
//                     sh '''
//                         echo "🔍 Buscando linhas adicionadas no PR..."
//
//                         git config --global credential.helper store
//                         echo "https://${GIT_USER}:${GIT_TOKEN}@github.com" > ~/.git-credentials
//
//                         git fetch origin main:main
//
//                         echo "🆕 Linhas adicionadas neste PR:"
//                         git diff main...HEAD | grep '^+[^+]' | sed 's/^+//' || echo "Nenhuma linha adicionada encontrada."
//                     '''
//                 }
//             }
//         }
//     }
// }


// Conexao com IA local
// pipeline {
//     agent any
//
//     stages {
//         stage('Testar conexão com IA local') {
//             steps {
//                 sh '''
//                     echo "Testando conexão com IA local..."
//
//                     JSON=$(jq -n --arg prompt "Se você recebeu esta mensagem corretamente, responda apenas com: recebido com sucesso." --arg model "gemma3:1b" '{
//                         model: $model,
//                         prompt: $prompt,
//                         stream: false
//                     }')
//
//                     AI_RESPONSE=$(curl -s http://host.docker.internal:11434/api/generate -d "$JSON" | jq -r .response)
//
//                     echo "Resposta da IA:"
//                     echo "$AI_RESPONSE"
//                 '''
//             }
//         }
//     }
// }


// jenkins sending diff to ai
// pipeline {
//     agent any
//
//     stages {
//         stage('Analisar linhas adicionadas com IA') {
//             steps {
//                 withCredentials([
//                     usernamePassword(
//                         credentialsId: 'e92cb10e-0dd1-4142-a0fb-29a9488e3116',
//                         usernameVariable: 'GIT_USER',
//                         passwordVariable: 'GIT_TOKEN'
//                     )
//                 ]) {
//                     sh '''
//                         git config --global credential.helper store
//                         echo "https://${GIT_USER}:${GIT_TOKEN}@github.com" > ~/.git-credentials
//
//                         git fetch origin main:main
//
//                         echo "Extraindo linhas adicionadas..."
//                         git diff main...HEAD | grep '^+[^+]' | sed 's/^+//' > added_lines.txt
//
//                         echo "Enviando linhas adicionadas para a IA local..."
//
//                         PROMPT=$(jq -Rs . < added_lines.txt)
//
//                         JSON=$(jq -n --arg prompt "Liste as palavras escritas incorretamente em inglês neste texto:\\n" --arg text "$PROMPT" --arg model "gemma3:1b" '{
//                             model: $model,
//                             prompt: ($prompt + $text),
//                             stream: false
//                         }')
//
//                         AI_RESPONSE=$(curl -s http://host.docker.internal:11434/api/generate -d "$JSON" | jq -r .response)
//
//                         echo "🧠 Resposta da IA:"
//                         echo "$AI_RESPONSE"
//                     '''
//                 }
//             }
//         }
//     }
// }
