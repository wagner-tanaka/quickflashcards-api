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
                    script {
                        def result = sh(
                            script: '''
                                git config --global credential.helper store
                                echo "https://${GIT_USER}:${GIT_TOKEN}@github.com" > ~/.git-credentials

                                git fetch origin main:main
                                git diff main...HEAD > changes.diff

                                echo "Linhas adicionadas no PR com 'foobarbaz':"
                                matches=$(awk '
                                /^\\+\\+\\+ b\\// { current_file = substr($0, 7) }
                                /^\\+.*foobarbaz/ {
                                    if ($0 !~ /echo.*foobarbaz/ && $0 !~ /awk.*foobarbaz/) {
                                        print current_file ":" $0
                                    }
                                }
                                ' changes.diff)

                                if [ -n "$matches" ]; then
                                    echo "$matches"
                                    echo "FOUND_MATCHES=true" > result.env
                                    echo "MATCH_COUNT=$(echo "$matches" | wc -l)" >> result.env
                                else
                                    echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."
                                    echo "FOUND_MATCHES=false" > result.env
                                    echo "MATCH_COUNT=0" >> result.env
                                fi
                            ''',
                            returnStdout: true
                        ).trim()

                        // Ler as variáveis do arquivo
                        def envVars = readFile('result.env').split('\n')
                        def foundMatches = false
                        def matchCount = 0

                        envVars.each { line ->
                            if (line.startsWith('FOUND_MATCHES=')) {
                                foundMatches = line.split('=')[1] == 'true'
                            }
                            if (line.startsWith('MATCH_COUNT=')) {
                                matchCount = line.split('=')[1] as Integer
                            }
                        }

                        // Alertas visuais baseados no resultado
                        if (foundMatches) {
                            // 1. Marcar o build como UNSTABLE (amarelo) para chamar atenção
                            currentBuild.result = 'UNSTABLE'

                            // 2. Adicionar badge visual no build
                            addShortText(
                                text: "⚠️ FOOBARBAZ ENCONTRADO! (${matchCount} ocorrências)",
                                color: "red",
                                background: "yellow"
                            )

                            // 3. Definir descrição do build
                            currentBuild.description = "🚨 ATENÇÃO: Palavra 'foobarbaz' encontrada em ${matchCount} linha(s)!"

                            // 4. Imprimir alerta grande no console
                            echo """
╔════════════════════════════════════════════════════════════════╗
║                            ALERTA!                             ║
║                                                                ║
║    🚨 PALAVRA 'FOOBARBAZ' ENCONTRADA NO CÓDIGO! 🚨            ║
║                                                                ║
║    Encontradas ${matchCount} ocorrência(s) no PR                        ║
║                                                                ║
║    Verifique o código antes de fazer merge!                   ║
╚════════════════════════════════════════════════════════════════╝
                            """

                            // 5. Criar arquivo de resultado para download
                            writeFile file: 'foobarbaz_report.txt', text: result
                            archiveArtifacts artifacts: 'foobarbaz_report.txt', fingerprint: true

                        } else {
                            // Build normal - verde
                            addShortText(
                                text: "✅ Nenhuma ocorrência de 'foobarbaz'",
                                color: "white",
                                background: "green"
                            )
                            currentBuild.description = "✅ Código limpo - sem 'foobarbaz'"
                        }
                    }
                }
            }
        }
    }

    post {
        always {
            // Limpar arquivos temporários
            sh 'rm -f changes.diff result.env || true'
        }
        unstable {
            // Enviar notificação quando build fica unstable (palavra encontrada)
            echo "🚨 BUILD MARCADO COMO UNSTABLE - FOOBARBAZ DETECTADO!"
        }
        success {
            echo "✅ Build completado com sucesso"
        }
    }
}
