// Import de pacotes
import React from 'react';
import { StatusBar, StyleSheet, Text, View } from 'react-native';
import { Provider as PaperProvider } from 'react-native-paper';
import {
    useFonts,
    Manjari_100Thin,
    Manjari_400Regular,
    Manjari_700Bold
} from "@expo-google-fonts/manjari";
import { ThemeProvider } from 'styled-components';
import AppLoading from 'expo-app-loading';

// Import de páginas
import { Home } from './pages/Home';                        //Home do cliente
import { Home as TIHome } from './pages/EmpresaTIHome';     //Home do servidor
import theme from './global/styles/theme';                  //Temas
import { AppLoading as AppLoad } from './AppLoading';       //AppLoading

// Páginas
import { RequestServices } from './pages/RequestServices';              //Pesquisa de serviços
import { SelectedService } from './pages/SelectedService';              //Serviço selecionado
import { ClientRegister } from './pages/ClientRegister/Cadastro';       // Registro de Cliente
import { UserTerms } from './pages/UserTerms';
import { Login } from './pages/Login';

export default function App() {
    const [fontsLoaded] = useFonts({
        Manjari_100Thin,
        Manjari_400Regular,
        Manjari_700Bold,
    });

    if (!fontsLoaded) {
        return <AppLoading />
    }

    return (
        <ThemeProvider theme={theme}>
            <PaperProvider>
                <StatusBar backgroundColor='transparent' barStyle='dark-content' translucent/>
                <Login />
            </PaperProvider>
        </ThemeProvider>
    );
}
