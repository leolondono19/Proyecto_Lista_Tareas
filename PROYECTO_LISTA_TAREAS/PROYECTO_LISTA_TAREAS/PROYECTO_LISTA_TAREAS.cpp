#include "Table.h"
#include <iostream>
using namespace std;

void pausa() {
    system("pause");
}

void clear() {
    system("cls");
}

int main()
{
	int const width = 81;
	int const heigth = 24;
	Table PantallaPrincipal(width, heigth);
    int i = 0;
    while (i != 8) {
        system("cls"); // borrar la pantalla (clear screen)
        cout << "\nBienvenido a tu control de tareas\n";
        cout << "\n1.- LISTA DE TAREAS ";
        cout << "\n2.- AGREGAR NUEVA TAREA";
        cout << "\n3.- ELIMINAR TAREA";
        cout << "\n4.- REPORTE DE MIS TAREAS";
        cout << "\n5.- Exit";
        cout << "\nChoose an option: \n";
        cin >> i;
        switch (i) {
        case 1:
            clear();
            PantallaPrincipal.displayMap(width, heigth);
            pausa();
            break;
        }
    }
}

