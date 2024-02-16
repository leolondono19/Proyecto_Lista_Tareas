#include "Table.h"
#include <iostream>
#include <windows.h>
#include <vector>

using namespace std;

void Table::gotoxy(int x, int y)
{
    COORD pos = { x, y };
    SetConsoleCursorPosition(GetStdHandle(STD_OUTPUT_HANDLE), pos);
}

void Table::displayMap(int width, int heigth) {
    for (int i = 1; i < width; i++) {
        gotoxy(i, 0);
        cout << "-";
        gotoxy(i, heigth);
        cout << "-";
        for (int j = 1; j < heigth; j++) {
            gotoxy(0, j);
            cout << "|";
            gotoxy(width, j);
            cout << '|';
        }
    }
}

Table::Table(int witdh, int height)
{
}
