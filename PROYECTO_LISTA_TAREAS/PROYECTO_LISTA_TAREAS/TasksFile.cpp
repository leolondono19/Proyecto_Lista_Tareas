#include "TasksFile.h"
#include <Windows.h>
#include <sstream>

void TasksFile::registerTask() {
    string taskName, taskDate;
    cout << "Enter task: ";
    cin.ignore();
    getline(cin, taskName);
    cout << "Enter task date (yyyy-mm-dd): ";
    cin >> taskDate;

    ifstream file("tasks.txt");
    if (!file.good()) {
        file.close();
        ofstream newFile("tasks.txt");
        newFile.close();
    }
    else {
        file.close();
    }

    ofstream outFile("tasks.txt", ofstream::out | ofstream::app);
    if (!outFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    outFile << taskName << " " << taskDate << " " << "pending" << endl; 

    outFile.close();

    cout << "Task added successfully." << endl;
}

void TasksFile::modifyTask() {
    ifstream inFile("tasks.txt");
    if (!inFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    displayTasks();

    int taskIndex;
    cout << "Enter task number to modify: ";
    cin >> taskIndex;
    if (taskIndex < 1) {
        cout << "Invalid task number." << endl;
        return;
    }

    string line;
    vector<string> lines;

    while (getline(inFile, line)) {
        lines.push_back(line);
    }

    inFile.close();

    ofstream outFile("tasks.txt", ofstream::out | ofstream::trunc);
    if (!outFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    ofstream completeFile("complete.txt", ofstream::out | ofstream::app);
    if (!completeFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    for (int i = 0; i < lines.size(); ++i) {
        if (i + 1 != taskIndex) {
            outFile << lines[i] << endl;
        }
        else {
            completeFile << lines[i] << endl;
        }
    }

    outFile.close();
    completeFile.close();

    if (taskIndex <= tasks.size()) {
        tasks.erase(tasks.begin() + taskIndex - 1);
    }

    cout << "Task modify successfully." << endl;
}

void TasksFile::displayCompletedTasks() {
    ifstream inFile("complete.txt");
    if (!inFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    string line;
    int taskNumber = 1;
    int i = 1;
    while (getline(inFile, line)) {
        string taskName, taskDate, taskStatus;
        int taskIndex = 0;

        int taskNameEnd = line.find_last_of(' ', line.length() - 1);
        int taskDateEnd = line.find_last_of(' ', taskNameEnd - 1);

        if (taskNameEnd == string::npos || taskDateEnd == string::npos) {
            continue;
        }

        taskName = line.substr(0, taskDateEnd);
        taskDate = line.substr(taskDateEnd + 1, taskNameEnd - taskDateEnd);
        taskStatus = line.substr(taskNameEnd + 1);

        if (i == 1) {
            gotoxy(0, 1);
        }

        cout << " " << taskNumber << ". ";
        cout << "Task Name: " << setw(25) << left << taskName;
        cout << "Limit Date: " << setw(18) << left << taskDate;
        cout << "Status: " << setw(5) << left << "Completed" << endl;

        taskNumber++;
        i++;
    }

    inFile.close();
}

void TasksFile::displayTasks() {
    ifstream inFile("tasks.txt");
    if (!inFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    string line;
    int taskNumber = 1;
    int i = 1;
    while (getline(inFile, line)) {
        string taskName, taskDate, taskStatus;
        int taskIndex = 0; 

        int taskNameEnd = line.find_last_of(' ', line.length() - 1);
        int taskDateEnd = line.find_last_of(' ', taskNameEnd - 1);

        if (taskNameEnd == string::npos || taskDateEnd == string::npos) {
            continue;
        }

        taskName = line.substr(0, taskDateEnd);
        taskDate = line.substr(taskDateEnd + 1, taskNameEnd - taskDateEnd);
        taskStatus = line.substr(taskNameEnd + 1);

        if (i == 1) {
            gotoxy(0, 1);
        }

        cout << " " << taskNumber << ". ";
        cout << "Task Name: " << setw(25) << left << taskName;
        cout << "Limit Date: " << setw(18) << left << taskDate;
        cout << "Status: " << setw(5) << left << taskStatus << endl;

        taskNumber++;
        i++;
    }

    inFile.close();
}

void TasksFile::deleteTask() {
    ifstream inFile("tasks.txt");
    if (!inFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    vector<string> lines;
    string line;
    while (getline(inFile, line)) {
        lines.push_back(line);
    }
    inFile.close();

    displayTasks();

    int taskIndex;
    cout << "Enter task number to delete: ";
    cin >> taskIndex;
    if (taskIndex < 1 || taskIndex > lines.size()) {
        cout << "Invalid task number." << endl;
        return;
    }

    lines.erase(lines.begin() + taskIndex - 1);

    ofstream outFile("tasks.txt", ofstream::out | ofstream::trunc);
    if (!outFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    for (const string& line : lines) {
        outFile << line << endl;
    }

    outFile.close();
    cout << "Task deleted successfully." << endl;
}

void TasksFile::gotoxy(int x, int y) {
    COORD pos = { x, y };
    SetConsoleCursorPosition(GetStdHandle(STD_OUTPUT_HANDLE), pos);
}

void TasksFile::updateFile() {
    ofstream outFile("tasks.txt", ofstream::out | ofstream::trunc);
    if (!outFile) {
        cout << "Unable to open file." << endl;
        return;
    }

    for (Task task : tasks) {
        outFile << task.name << "|" << task.date << "|" << (task.completed ? "1" : "0") << endl;
    }

    outFile.close();
}