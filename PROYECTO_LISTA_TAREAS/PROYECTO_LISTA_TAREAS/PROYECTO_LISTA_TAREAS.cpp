#include "Border.h"
#include "TasksFile.h"
#include <iostream>
#include <fstream>
#include <iomanip>

using namespace std;

void pausa() {
    system("pause");
}

void clear() {
    system("cls");
}

int main() {
    int const width = 90;
    int const heigth = 24;
    Border PantallaPrincipal(width, heigth);
    TasksFile taskFile;

    int i = 0;
    while (i != 5) {
        clear();
        cout << "\nBienvenido a tu control de tareas\n";
        cout << "\n1.- AGREGAR NUEVA TAREA";
        cout << "\n2.- MODIFICAR ESTADO";
        cout << "\n3.- REPORTE DE MIS TAREAS";
        cout << "\n4.- TAREAS COMPLETADAS";
        cout << "\n5.- Exit";
        cout << "\nChoose an option: \n";
        cin >> i;

        switch (i) {
        case 1:
            clear();
            taskFile.registerTask();
            pausa();
            break;
        case 2:
            clear();
            taskFile.deleteTask();
            pausa();
            break;
        case 3:
            clear();
            taskFile.displayTasks();
            PantallaPrincipal.displayBorder(width, heigth);
            pausa();
            break;
        case 4:
            clear();
            taskFile.displayCompletedTasks();
            PantallaPrincipal.displayBorder(width, heigth);
            pausa();
            break;
        case 5:
            exit(1);
        }
    }
}




