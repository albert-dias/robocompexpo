// Import de pacotes
import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { StyleSheet, Text, View } from 'react-native';
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
import { Home } from './pages/Home';
import { Home as TIHome } from './pages/EmpresaTIHome';
import theme from './global/styles/theme';
import { AppLoading as AppLoad } from './AppLoading';
import { RequestServices } from './pages/RequestServices';

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
                <RequestServices />
            </PaperProvider>
        </ThemeProvider>
    );
}
