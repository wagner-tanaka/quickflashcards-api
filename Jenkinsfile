pipeline {
    agent any

    stages {
        stage('Analisar linhas adicionadas com IA') {
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

                        # Coleta as linhas adicionadas com nome do arquivo e linha
                        git diff main...HEAD --unified=0 | awk '
                        /^diff --git/ {
                            file = "";
                        }
                        /^\\+\\+\\+ b\\// {
                            file = substr($0, 7);
                        }
                        /^@@/ {
                            split($0, parts, "\\+");
                            split(parts[2], nums, ",");
                            line = nums[1];
                        }
                        /^\\+[^\\+]/ {
                            line++;
                            printf "File: %s, Line: %d - %s\\n", file, line, substr($0, 2);
                        }
                        ' > added_lines.txt

                        echo "📄 Conteúdo extraído:"
                        cat added_lines.txt

                        echo "🤖 Enviando para a IA local..."

                        PROMPT=$(jq -Rs . < added_lines.txt)

                        JSON=$(jq -n \
                          --arg prompt "Analise as seguintes linhas de código que foram adicionadas.\\n\\nAponte apenas onde há algo potencialmente errado e o que esta errado.\\n\\nResponda usando este formato:\\nFile: NOME_DO_ARQUIVO, Line: NÚMERO - O que esta errado\\n\\nLinhas:\\n" \
                          --arg text "$PROMPT" \
                          --arg model "gemma3:1b" '{
                            model: $model,
                            prompt: ($prompt + $text),
                            stream: false
                        }')

                        AI_RESPONSE=$(curl -s http://host.docker.internal:11434/api/generate -d "$JSON" | jq -r .response)

                        echo ""
                        echo "🧠 Resposta da IA:"
                        echo "$AI_RESPONSE"
                    '''
                }
            }
        }
    }
}



// lines and files where was changed ok
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
//
//                         git diff main...HEAD --unified=0 | awk '
//                         /^diff --git/ {
//                             file = "";
//                         }
//                         /^\\+\\+\\+ b\\// {
//                             file = substr($0, 7);
//                         }
//                         /^@@/ {
//                             # extrai número da linha da direita (ex: +42)
//                             split($0, parts, "\\+");
//                             split(parts[2], nums, ",");
//                             line = nums[1];
//                         }
//                         /^\\+[^\\+]/ {
//                             printf "File: %s, Line: %d - %s\\n", file, line, substr($0, 2);
//                             line++;
//                         }
//                         '
//                     '''
//                 }
//             }
//         }
//     }
// }

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
