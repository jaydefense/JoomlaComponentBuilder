#-------------------------------------------------
#
# Project created by QtCreator 2015-04-09T22:51:26
#
#-------------------------------------------------

QT       += core gui sql

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = ComponentBuilder
TEMPLATE = app


SOURCES += main.cpp\
        mainwindow.cpp \
    dbtools.cpp \
    tablemodel.cpp \
    templateparser.cpp \
    tabletranslator.cpp \
    tabmodelwidget.cpp \
    config.cpp

HEADERS  += mainwindow.h \
    dbtools.h \
    tablemodel.h \
    templateparser.h \
    tabletranslator.h \
    tabmodelwidget.h \
    config.h

FORMS    += mainwindow.ui \
    tabmodelwidget.ui
