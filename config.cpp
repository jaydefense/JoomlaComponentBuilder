#include "config.h"

#include <QXmlStreamWriter>
/*
Config::Config()
{
    const QSettings::Format f=QSettings::registerFormat("xml", Config::readImpl, Config::writeImpl);
    QSettings::setDefaultFormat(f);
    s = new QSettings(f,QSettings::UserScope,QString("MyProject"),QString("settings"));
}


bool Config::writeImpl(QIODevice& device, QSettings::SettingsMap& map)
{
    QXmlStreamWriter xml(&device);
    xml.setAutoFormatting(true);
    xml.writeStartDocument();
    xml.writeStartElement("Settings");
    QStringList prev;
    QSettings::SettingsMap::ConstIterator map_i;
    for (map_i = map.begin(); map_i != map.end(); map_i++)
    {
        QStringList elements = map_i.key().split("/");
        int x = 0;
        while (x < prev.size() && elements.at(x) == prev.at(x)) {
            x++;
        }
        for (int i = prev.size() - 1; i >= x; i--)
        {
            xml.writeEndElement();
        }
        for (int i = x; i < elements.size(); i++)
        {
            xml.writeStartElement(elements.at(i));
        }
        xml.writeCharacters(map_i.value().toString());
        prev = elements;
    }
    for (int i = 0; i < prev.size(); i++)
    {
        xml.writeEndElement();
    }
    xml.writeEndElement();
    xml.writeEndDocument();
    return true;
}

bool Config::readImpl(QIODevice& device, QSettings::SettingsMap& map)
{
    QXmlStreamReader xmlReader(&device);
    QStringList elements;
    while (!xmlReader.atEnd() && !xmlReader.hasError()) {
        xmlReader.readNext();
        if (xmlReader.isStartElement() && xmlReader.name() != "Settings")
        {
            elements.append(xmlReader.name().toString());
        }
        else if (xmlReader.isEndElement())
        {
            if (!elements.isEmpty())
            {
                elements.removeLast();
            }
        } else if (xmlReader.isCharacters() && !xmlReader.isWhitespace())
        {
            QString key;
            for (int i = 0; i < elements.size(); i++)
            {
                if (i != 0)
                {
                    key += "/";
                }
                key += elements.at(i);
            }
            map[key] = xmlReader.text().toString();
        }
    }
    if (xmlReader.hasError())
    {
        qDebug() << xmlReader.errorString();
        return false;
    }
    return true;
}
*/
