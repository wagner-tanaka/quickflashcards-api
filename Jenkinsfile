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

                        # Process diff to show filename:line_number:content
                        current_file=""
                        line_num=0

                        while IFS= read -r line; do
                            if [[ "$line" =~ ^\+\+\+\ b/ ]]; then
                                current_file="${line#'+++ b/'}"
                                line_num=0
                            elif [[ "$line" =~ ^@@.*\+ ]]; then
                                # Extract starting line number
                                line_num=$(echo "$line" | grep -o '+[0-9]*' | head -1 | cut -c2-)
                                line_num=$((line_num - 1))
                            elif [[ "$line" =~ ^\+ ]]; then
                                line_num=$((line_num + 1))
                                # Check if line contains foobarbaz but exclude Jenkins script lines
                                if [[ "$line" == *"foobarbaz"* ]] && [[ "$line" != *"echo"*"foobarbaz"* ]] && [[ "$line" != *"grep"*"foobarbaz"* ]] && [[ "$line" != *"IFS"* ]]; then
                                    content="${line#+}"
                                    echo "$current_file:$line_num:$content"
                                fi
                            fi
                        done < changes.diff

                        # Check if we found any matches
                        if ! grep -q '^+.*foobarbaz' changes.diff; then
                            echo "Nenhuma linha adicionada com 'foobarbaz' encontrada."
                        fi
                    '''
                }
            }
        }
    }
}
