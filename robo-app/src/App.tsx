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
import theme from './global/styles/theme';                  //Temas
import { AppLoading as AppLoad } from './AppLoading';       //AppLoading

// Páginas
import { Home } from './pages/Home';                                    //Home do cliente
import { Home as TIHome } from './pages/EmpresaTIHome';                 //Home do servidor
import { RequestServices } from './pages/RequestServices';              //Pesquisa de serviços
import { SelectedService } from './pages/SelectedService';              //Serviço selecionado
import { ClientRegister } from './pages/ClientRegister/Cadastro';       //Registro de cliente
import { UserTerms } from './pages/UserTerms';                          //Termos de uso
import { Login } from './pages/Login';                                  //Login
import { AdmHome } from './pages/AdmHome';                              //Página inicial do adm
import { AdmMetrics } from './pages/AdmHome/AdmMetrics';                //Página de parâmetros do adm
import { Agenda } from './pages/Agenda';                                //Horários do técnico
import { EditPassword } from './pages/EditPassword';                    //Mudar a senha
import { EditProfile } from './pages/EditProfile';                      //Mudar informações do perfil

export default function App() {
    const [fontsLoaded] = useFonts({
        Manjari_100Thin,
        Manjari_400Regular,
        Manjari_700Bold,
    });

    if (!fontsLoaded) {
        return <AdmHome />
    }

    return (
        <ThemeProvider theme={theme}>
            <PaperProvider>
                <StatusBar backgroundColor='transparent' barStyle='dark-content' translucent />
                <EditProfile />
            </PaperProvider>
        </ThemeProvider>
    );
}
