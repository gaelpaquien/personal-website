#!/bin/bash

execute_command() {
    script_name=$1
    command_label=$2
    acceptable_exit_code=${3:-0}
    working_dir=$4
    shift 4
    command="$@"

    echo "$script_name: Executing: $command_label in $working_dir..."
    (cd "$working_dir" && $command)
    EXIT_CODE=$?
    if [ $EXIT_CODE -ne 0 ] && [ $EXIT_CODE -ne $acceptable_exit_code ]; then
        echo "$script_name: Error: $command_label failed with exit code $EXIT_CODE"; exit 1;
    fi
}
