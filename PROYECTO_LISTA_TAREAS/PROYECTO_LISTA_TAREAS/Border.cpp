#include "Border.h"
#include <iostream>
#include <windows.h>
#include <vector>

using namespace std;

void Border::gotoxy(int x, int y)
{
    COORD pos = { x, y };
    SetConsoleCursorPosition(GetStdHandle(STD_OUTPUT_HANDLE), pos);
}

void Border::displayBorder(int width, int heigth) {
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
    cout << endl << endl;
}

Border::Border(int witdh, int height)
{
}
