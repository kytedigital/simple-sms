export const ADD_PROCESSES = "ADD_PROCESSES";
export const ADD_PROCESS = "ADD_PROCESSES";

export const addProcess = process => ({
    type: ADD_PROCESS,
    payload: process
});

export const addProcesses = processes => ({
    type: ADD_PROCESSES,
    payload: processes
});
