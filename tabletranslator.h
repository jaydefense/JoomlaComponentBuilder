#include <QString>
#include <QTableWidget>

#ifndef TABLETRANSLATOR_H
#define TABLETRANSLATOR_H

class TableTranslator : public QTableWidget
{
public:
    explicit TableTranslator(QWidget *parent = 0);
    void AddLine(QString code, QString value, bool site=true, bool admin=true, bool admSys=true);

    void AddLine(QString table, QString column, QString type, QString value, bool site=true, bool admin=true, bool admSys=true);
    QString toStringLanguage();
private:
    QString componantName;
    QString prefix;
};

#endif // TABLETRANSLATOR_H
