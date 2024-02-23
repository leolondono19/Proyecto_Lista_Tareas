#pragma once
class Border
{
public:
	void displayBorder(int width, int heigth);
	Border(int witdh, int height);
	void gotoxy(int x, int y);
	char TableSize[81][24];
private:
	int width, heigth;
};

