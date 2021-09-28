// Import de pacotes
import React, { useEffect, useState } from 'react';
import { Text } from 'react-native-paper';
import { Alert, Image, ImageBackground, StyleSheet, View } from 'react-native';
import Slider from '@react-native-community/slider';
import { ScrollView, TouchableOpacity } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';
import imgBanner from '../../../assets/images/banner.png';
import { Value } from 'react-native-reanimated';

export function AdmMetrics() {
    // Variáveis
    const [list, setList] = useState(['']);

    const changeValue = (val, index) => {
        var lista = list.slice();
        lista[index] = val;
        setList(lista);
    }

    useEffect(() => {
        changeValue(10, 0);
    }, []);
    // Construção da página
    return (
        <View style={{ flexGrow: 1 }}>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container
                        pb
                        // padding={30}
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <Image
                            source={logo}
                            resizeMode='contain'
                            style={{
                                width: 170,
                                height: 170,
                                marginTop: '-8%',
                                marginBottom: '-13%',
                            }}
                        />
                    </Container>

                    <Text style={styles.textStyleF}>
                        RoboComp - Administração de métricas
                    </Text>

                    <TouchableOpacity style={{
                        alignContent: 'flex-start',
                        alignItems: 'flex-start',
                        alignSelf: 'flex-start',
                        marginBottom: '2%'
                    }}
                        onPress={async () => { console.log('login') }}>
                        <FontAwesome5
                            name='power-off'
                            color={theme.colors.white}
                            size={40}
                        />
                    </TouchableOpacity>
                </ImageBackground>
            </ContainerTop>

            <View style={{
                flexDirection: 'row',
                alignItems: 'center',
                alignSelf: 'center',
                backgroundColor: '#F4F1F0',
                width: '100%',
                justifyContent: 'center',
                height: '8%',
            }}>
                <Text style={{ marginHorizontal: 10, marginTop: 5 }}>EmpresaTI</Text>
                <TouchableOpacity
                    style={styles.anuncioIcon}
                    onPress={() => { }}
                >
                    <FontAwesome5
                        name='toggle-off'
                        color={theme.colors.darkGray}
                        size={40}
                    />
                </TouchableOpacity>
                <Text style={{ marginHorizontal: 10, marginTop: 5 }}>Clientes</Text>
            </View>
            <View style={{ flexDirection: 'row', alignItems: 'center', backgroundColor: theme.colors.gray, justifyContent: 'center' }}>
                <TouchableOpacity onPress={() => { console.log('voltar') }}>
                    <FontAwesome5
                        name='users-cog'
                        colors={theme.colors.contrast}
                        size={40}
                    />
                </TouchableOpacity>
            </View>
            <ScrollView style={styles.scrollView}>
                <View style={styles.viewn}>
                    {(list !== undefined) ? list.map((plano, index) =>
                        <View style={{ flexDirection: 'row', alignItems: 'center' }}>
                            <Text style={{ width: '10%', marginHorizontal: 10 }}>Free</Text>
                            <Slider
                                style={{ width: '70%', height: 40 }}
                                value={25}
                                maximumValue={50}
                                minimumValue={0}
                                minimumTrackTintColor={theme.colors.slider}
                                thumbTintColor={theme.colors.slider}
                                step={1}
                                onValueChange={(value) => { changeValue(value, index) }}
                            />
                            <Text style={{ width: '15%', marginHorizontal: 10 }}>{JSON.stringify(list[index])} km</Text>
                        </View>
                    ) : <View />
                    }
                    <TouchableOpacity
                        style={{
                            alignItems: 'center',
                            alignSelf: 'center',
                            marginTop: '5%',
                            padding: 10,
                            backgroundColor: theme.colors.slider,
                            width: '80%',
                            borderRadius: 8,
                        }}
                        onPress={() => 'Update de plano'}>
                        <Text style={{ fontWeight: 'bold' }}>Salvar Alterações</Text>
                    </TouchableOpacity>
                </View>
            </ScrollView>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        flexGrow: 1,
        backgroundColor: '#F4F1F0',
        height: '68%',
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    viewn: {
        height: 'auto',
        justifyContent: 'space-around',
        margin: 10,
        padding: 20,
    },
    anuncioCard: {
        flexDirection: 'row',
        minHeight: 50,
        width: '90%',
        marginHorizontal: '5%',
        marginVertical: '1%',
        borderRadius: 8,
        borderWidth: 1,
        borderColor: 'black',
        alignItems: 'center',
        justifyContent: 'space-between',
        paddingHorizontal: '2%',
    },
    anuncioIcon: {
        flex: 1,
        marginHorizontal: 5,
        justifyContent: 'center'
    },
});