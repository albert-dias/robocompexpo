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
import { AcceptServices } from './pages/Services/accept';               //Serviços aceitos (técnico)
import { AddService } from './pages/Services/add';                      //Adicionar serviço (técnico)
import { AdmHome } from './pages/AdmHome';                              //Página inicial do adm
import { AdmMetrics } from './pages/AdmHome/AdmMetrics';                //Página de parâmetros do adm
import { Agenda } from './pages/Agenda';                                //Horários do técnico
import { ClientRegister } from './pages/ClientRegister/Cadastro';       //Registro de cliente
import { EditPassword } from './pages/EditPassword';                    //Mudar a senha
import { EditProfile } from './pages/EditProfile';                      //Mudar informações do perfil
import { EditService } from './pages/Services/edit';                    //Editar serviço (técnico)
import { EmpresaRegister } from './pages/EmpresaRegister/Cadastro';     //Registro de técnico
import { FinishedOS } from './pages/Services/finishedOS';               //Serviços finalizados (técnico)
import { FinishedOSClient } from './pages/Services/finishedOSClient';   //Serviços finalizados (cliente)
import { FollowServices } from './pages/Services/follow';               //Acompanhar os serviços (liente)
import { History } from './pages/Services/history';                     //Registros de serviços (técnico)
import { Home } from './pages/Home';                                    //Home do cliente
import { Home as TIHome } from './pages/EmpresaTIHome';                 //Home do servidor
import { InOrder } from './pages/InOrder';                              //Usado para páginas em construção
import { InProgress } from './pages/InProgress';                        //Menu para as OS (requisitadas, em andamento ou finalizadas) (técnico)
import { Login } from './pages/Login';                                  //Login
import { Plans } from './pages/Plans';                                  //Mostra os planos disponíveis
import { Profile } from './pages/Profile';                              //Página do perfil
import { Request } from './pages/Services/request';
import { RequestServices } from './pages/Services/list';                //Lista de serviços
import { SearchService } from './pages/Services/search';                //Pesquisar serviço (técnico)
import { SelectedService } from './pages/Services/selected';            //Serviço selecionado
import { ShoppingCart } from './pages/ShoppingCart';                    //Carrinho de compras
import { ShowService } from './pages/Services/show';                    //Menu de serviços pedidos (cliente)
import { TrackServices } from './pages/Services/status';                //Saber os serviços agendados (técnico)
import { UserTerms } from './pages/UserTerms';                          //Termos de uso
import { YourRequests } from './pages/Services/yourRequest';            //Menu de serviços (cliente)
import { YourServices } from './pages/Services/yourServices';           //Menu dos serviços (técnico)

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
                <EmpresaRegister />
            </PaperProvider>
        </ThemeProvider>
    );
}
