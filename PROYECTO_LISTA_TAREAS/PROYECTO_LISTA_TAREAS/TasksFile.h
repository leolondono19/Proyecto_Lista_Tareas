#ifndef TASKS_FILE_H
#define TASKS_FILE_H

#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <iomanip>
using namespace std;

class TasksFile {
public:
    TasksFile() {}

    void registerTask();
    void deleteTask();
    void displayCompletedTasks();
    void displayTasks();
    void updateTaskStatus();
    void gotoxy(int x, int y);

private:
    struct Task {
        string name;
        string date;
        bool completed;
    };

    vector<Task> tasks;

    void updateFile();
};

#endif




