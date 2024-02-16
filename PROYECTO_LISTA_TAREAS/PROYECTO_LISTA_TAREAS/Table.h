#pragma once
class Table
{
public:
	void displayMap(int width, int heigth);
	Table(int witdh, int height);
	void gotoxy(int x, int y);
	char TableSize[81][24];
private:
	int width, heigth;
};

