// Import de pacotes
import React, { useCallback, useEffect, useRef, useState } from 'react';
import {
    Alert,
    Image,
    ImageBackground,
    Platform,
    StyleSheet,
    TouchableOpacity,
    TouchableWithoutFeedback,
    View
} from 'react-native';
import { LinearGradient } from 'expo-linear-gradient';
import { Checkbox, Dialog, Portal, Text } from 'react-native-paper';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/native';
import DateTimePicker from '@react-native-community/datetimepicker'

// Import de páginas
import { Input } from '../../components/GlobalCSS';
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import request from '../../util/request';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';
import api from '../../services/api';

export function Agenda({ navigation }: StackScreenProps<ParamListBase>) {
    // Variáveis

    const [horarios, setHorarios] = useState([]);
    const [horaStart, setHoraStart] = useState(new Date());
    const [horaFinish, setHoraFinish] = useState(new Date());

    const [workID, setWorkID] = useState('');
    const [horaSeletor, setHoraSeletor] = useState([]);
    const [horaSeletorStart, setHoraSeletorStart] = useState(new Date());
    const [horaSeletorFinish, setHoraSeletorFinish] = useState(new Date());

    const [show, setShow] = useState(false);
    const [showEdit, setShowEdit] = useState(false);
    const [show2, setShow2] = useState(false);
    const [showEdit2, setShowEdit2] = useState(false);
    const [show3, setShow3] = useState(false);
    const [showEdit3, setShowEdit3] = useState(false);

    const [ativo, setAtivo] = useState(false);

    const addRef = useRef(null);

    const [checked0, setChecked0] = useState(false);
    const [checked1, setChecked1] = useState(false);
    const [checked2, setChecked2] = useState(false);
    const [checked3, setChecked3] = useState(false);
    const [checked4, setChecked4] = useState(false);
    const [checked5, setChecked5] = useState(false);
    const [checked6, setChecked6] = useState(false);
    var contador;

    var week = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

    // Funções

    const onChange = (event, selectedDate) => {
        const currentDate = selectedDate || horaStart;
        setShow2(Platform.OS === 'ios');
        setHoraStart(currentDate);
        console.log('HORAS 1: ' + currentDate.toString().substring(16, 21));
        setShow2(false);
    };
    const onChange2 = (event, selectedDate) => {
        const currentDate = selectedDate || horaFinish;
        setShow3(Platform.OS === 'ios');
        setHoraFinish(currentDate);
        console.log('HORAS 2: ' + currentDate.toString().substring(16, 21))
        setShow3(false);
    };
    const onChange3 = (event, selectedDate) => {
        const currentDate = selectedDate || horaSeletorStart;
        setShowEdit2(Platform.OS === 'ios');
        setHoraSeletorStart(currentDate);
        console.log('HORAS 3: ' + currentDate.toString().substring(16, 21));
        setShowEdit2(false);
    };

    const onChange4 = (event, selectedDate) => {
        const currentDate = selectedDate || horaSeletorFinish;
        setShowEdit3(Platform.OS === 'ios');
        setHoraSeletorFinish(currentDate);
        console.log('HORAS 4: ' + currentDate.toString().substring(16, 21));
        setShowEdit3(false);
    };

    // Setar todos os horários de trabalho na tela
    const setAllWork = async () => {
        try {
            const response = await api.get('user/schedule');

            setHorarios(response.data.sort((n1, n2) => {
                if (n1.weekday > n2.weekday) {
                    return 1;
                }

                if (n1.weekday < n2.weekday) {
                    return -1;
                }

                return 0;
            }));
            // console.log(response.data);
        } catch (e) { console.log(e); }
    };

    // Adicionar novos horários de trabalho
    const addWork = async () => {
        var checklist = [checked0, checked1, checked2, checked3, checked4, checked5, checked6];
        var weekday = ['0', '1', '2', '3', '4', '5', '6'];

        let atv = [];
        contador = 0;

        for (var i = 0; i < checklist.length; i++) {
            if (checklist[i]) {
                atv.push(Number(weekday[i]));
                contador++;
            }
        }

        if (contador !== 0) {
            setShow(false);

            try {
                const response = await api.post('user/schedule', {
                    weekday: atv,
                    start_time: horaStart.toString().substring(16, 24),
                    finish_time: horaFinish.toString().substring(16, 24),
                });

                console.log('RESPONSE: %s', response.data);
                setAllWork();
            } catch (e) { console.log(e.response.data.message); }

        } else {
            Alert.alert('AVISO!!!', 'Não foi marcado nenhum dia da semana.',
                [{ text: 'OK', onPress: () => { } }]
            );
        }
    }

    // Update dos horários já cadastrados
    const updateWork = async () => {
        console.log('HoraSelStart: ' + horaSeletorStart.toString().substring(16, 24));
        console.log('HoraSelFinish: ' + horaSeletorFinish.toString().substring(16, 24));
        console.log('ID: ' + workID);
        try {
            const response = await api.put('user/schedule', {
                weekday_id: workID,
                start_time: horaSeletorStart.toString().substring(16, 22)+'00',
                finish_time: horaSeletorFinish.toString().substring(16, 22)+'00',
            });
            
            console.log(response.data);
            setAllWork();
            setShowEdit(false);
        } catch (e) { console.log('ERROR DE EDIT, %s', e.response.data.message); }
    }
    
    const delWork = async (workID) => {
        try{
            const response = await api.put('user/schedule', {
                weekday_id: workID,
            });
            setAllWork();
        } catch (e) { console.log('ERROR DE EDIT, %s', e.response.data.message); }
    }
    function setChecks() {
        setChecked0(false);
        setChecked1(false);
        setChecked2(false);
        setChecked3(false);
        setChecked4(false);
        setChecked5(false);
        setChecked6(false);
        setShow(false);
        setShowEdit(false);
    }

    useEffect(() => {
        setShow(false);
        setAllWork();
    }, []);

    // Construção da página
    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}
                    >
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: '-8%',
                                marginBottom: '-13%',
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => navigation.goBack()}
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}
                        >
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles.textStyleF}>
                            RoboComp - Horários de Trabalho
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <Container>
                <View style={styles.scrollView}>
                    <TouchableOpacity
                        ref={addRef}
                        style={styles.buttonADD}
                        onPress={() => {
                            setChecks();
                            setAtivo(false);
                            setHoraStart(new Date(1609459200000));
                            setHoraFinish(new Date(1609459200000));
                            setShow(true);
                        }}>
                        <LinearGradient
                            colors={theme.colors.gradientInvert}
                            start={{ x: 0.0, y: 1.0 }}
                            end={{ x: 1.0, y: 1.0 }}
                            style={styles.buttonBorder}
                        >
                            <Text style={styles.buttonText}>Adicionar horário</Text>
                        </LinearGradient>
                    </TouchableOpacity>
                    <Text style={{
                        paddingTop: '15%',
                        paddingLeft: '5%',
                        fontSize: 16,
                        fontWeight: 'bold',
                        marginBottom: '5%'
                    }}>Horários de Trabalho:</Text>
                    <ScrollView>
                        <View style={styles.corpo}>
                            <View style={{ flex: 1, flexDirection: 'column', marginHorizontal: '5%' }}>
                                {(horarios.map(hora => (
                                    <View style={{ flexDirection: 'row', width: '100%', marginTop: 2, alignItems: 'center' }}>
                                        <Text style={styles.norma1}>{week[hora.weekday]}</Text>
                                        <Text style={styles.norma2}>{hora.start_time.toString()}</Text>
                                        <Text style={styles.norma3}>-</Text>
                                        <Text style={styles.norma4}>{hora.finish_time.toString()}</Text>
                                        <TouchableOpacity style={{ marginRight: 5, marginLeft: 'auto' }}
                                            onPress={() => { setWorkID(hora.id); setShowEdit(true) }}
                                        >
                                            <FontAwesome5
                                                name='edit'
                                                size={35}
                                                color={theme.colors.contrast}
                                            />
                                        </TouchableOpacity>
                                        <TouchableOpacity style={{ marginRight: 5, marginLeft: 'auto' }}
                                            onPress={() => {
                                                Alert.alert('AVISO', 'Deseja excluir esse horário?',
                                                    [{
                                                        text: 'SIM',
                                                        onPress: () => { delWork(hora.id) }
                                                    }, {
                                                        text: 'NÃO',
                                                        onPress: () => { }
                                                    }])
                                            }}>
                                            <FontAwesome5
                                                name='trash-alt'
                                                size={35}
                                                color={theme.colors.contrast}
                                            />
                                        </TouchableOpacity>
                                    </View>
                                )))}
                            </View>
                        </View>
                    </ScrollView>
                </View>
                <ScrollView style={{ marginBottom: '30%' }}>
                    <Portal>
                        <Dialog
                            style={styles.dialog}
                            visible={show}
                            onDismiss={() => setChecks()}
                        >
                            <Dialog.Title style={{ paddingTop: 65 }}>
                                Selecione Dias e Horário
                            </Dialog.Title>
                            <Dialog.Content style={{ flexDirection: 'column' }}>
                                <View style={{ flexDirection: 'row' }}>
                                    {
                                        (checked0 === false) ?
                                            <TouchableOpacity ref={addRef} style={styles.touchDialog} onPress={() => { setChecked0(!checked0) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'DOM'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked0(!checked0) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'DOM'}</Text>
                                            </TouchableOpacity>
                                    }
                                    {
                                        (checked1 === false) ?
                                            <TouchableOpacity style={styles.touchDialog} onPress={() => { setChecked1(!checked1) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'SEG'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked1(!checked1) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'SEG'}</Text>
                                            </TouchableOpacity>
                                    }
                                    {
                                        (checked2 === false) ?
                                            <TouchableOpacity style={styles.touchDialog} onPress={() => { setChecked2(!checked2) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'TER'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked2(!checked2) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'TER'}</Text>
                                            </TouchableOpacity>
                                    }
                                    {
                                        (checked3 === false) ?
                                            <TouchableOpacity style={styles.touchDialog} onPress={() => { setChecked3(!checked3) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'QUA'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked3(!checked3) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'QUA'}</Text>
                                            </TouchableOpacity>
                                    }
                                    {
                                        (checked4 === false) ?
                                            <TouchableOpacity style={styles.touchDialog} onPress={() => { setChecked4(!checked4) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'QUI'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked4(!checked4) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'QUI'}</Text>
                                            </TouchableOpacity>
                                    }
                                    {
                                        (checked5 === false) ?
                                            <TouchableOpacity style={styles.touchDialog} onPress={() => { setChecked5(!checked5) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'SEX'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked5(!checked5) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'SEX'}</Text>
                                            </TouchableOpacity>
                                    }
                                    {
                                        (checked6 === false) ?
                                            <TouchableOpacity style={styles.touchDialog} onPress={() => { setChecked6(!checked6) }}>
                                                <Text style={{ color: 'rgba(255,0,0,1)' }}>{'SAB'}</Text>
                                            </TouchableOpacity>
                                            :
                                            <TouchableOpacity style={styles.touchDialog2} onPress={() => { setChecked6(!checked6) }}>
                                                <Text style={{ color: 'rgba(0,125,0,1)' }}>{'SAB'}</Text>
                                            </TouchableOpacity>
                                    }
                                </View>
                                <View style={{ marginHorizontal: '5%', marginTop: 10, flexDirection: 'row', justifyContent: 'space-evenly' }}>
                                    {show2 && <DateTimePicker
                                        value={horaStart}
                                        mode='time'
                                        is24Hour={true}
                                        display='clock'
                                        onChange={onChange}
                                    />}
                                    <TouchableWithoutFeedback onPress={() => { setShow2(true) }} disabled={ativo}>
                                        <View style={(ativo) ? styles.hourView2 : styles.hourView}>
                                            <Text style={{ fontSize: 13 }}>Início</Text>
                                            <Text style={{ fontSize: 15 }}>{horaStart.toString().substring(16, 21)}</Text>
                                        </View>
                                    </TouchableWithoutFeedback>
                                    {show3 && <DateTimePicker
                                        value={horaFinish}
                                        mode='time'
                                        is24Hour={true}
                                        display='clock'
                                        onChange={onChange2}
                                    />}
                                    <TouchableWithoutFeedback onPress={() => setShow3(true)} disabled={ativo}>
                                        <View style={(ativo) ? styles.hourView2 : styles.hourView}>
                                            <Text style={{ fontSize: 13 }}>Fim</Text>
                                            <Text style={{ fontSize: 15 }}>{horaFinish.toString().substring(16, 21)}</Text>
                                        </View>
                                    </TouchableWithoutFeedback>
                                </View>
                                <View style={styles.checkbox}>
                                    <Checkbox
                                        status={ativo ? 'checked' : 'unchecked'}
                                        onPress={() => setAtivo(!ativo)}
                                    />
                                    <Text>Fechado</Text>
                                </View>
                                <View style={{ flexDirection: 'row', marginTop: '10%', alignSelf: 'center' }}>
                                    <Dialog.Actions><TouchableOpacity style={styles.touchDialog3} onPress={() => addWork()}><Text>Adicionar</Text></TouchableOpacity></Dialog.Actions>
                                    <Dialog.Actions><TouchableOpacity onPress={() => setChecks()} style={styles.touchDialog3}><Text>Cancelar</Text></TouchableOpacity></Dialog.Actions>
                                </View>
                            </Dialog.Content>
                        </Dialog>
                    </Portal>
                </ScrollView>
                <Portal>
                    <Dialog style={styles.dialog} visible={showEdit} onDismiss={() => setChecks()}>
                        <Dialog.Title style={{ paddingTop: 65 }}>Editar Horário</Dialog.Title>
                        <Dialog.Content style={{ flexDirection: 'column' }}>
                            <View style={{ marginHorizontal: '5%', marginTop: 10, flexDirection: 'row', justifyContent: 'space-evenly' }}>
                                {showEdit2 && <DateTimePicker
                                    value={horaSeletorStart}
                                    mode='time'
                                    is24Hour={true}
                                    display='clock'
                                    onChange={onChange3}
                                />}
                                <Input
                                    style={{ width: '35%' }}
                                    mode='flat'
                                    label='Abre:'
                                    value={horaSeletorStart.toString().substring(16, 21)}
                                    onChangeText={() => setShowEdit2(true)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onFocus={() => setShowEdit2(true)}
                                />
                                {showEdit3 && <DateTimePicker
                                    value={horaSeletorFinish}
                                    mode='time'
                                    is24Hour={true}
                                    display='clock'
                                    onChange={onChange4}
                                />}
                                <Input
                                    style={{ width: '35%' }}
                                    mode='flat'
                                    label='Fecha:'
                                    value={horaSeletorFinish.toString().substring(16, 21)}
                                    onChangeText={() => setShowEdit3(true)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onFocus={() => setShowEdit3(true)}
                                />
                            </View>
                            <View style={{ flexDirection: 'row', marginTop: '10%', alignSelf: 'center' }}>
                                <Dialog.Actions><TouchableOpacity style={styles.touchDialog3} onPress={() => { updateWork() }}><Text>Alterar</Text></TouchableOpacity></Dialog.Actions>
                                <Dialog.Actions><TouchableOpacity style={styles.touchDialog3} onPress={() => { setChecks() }}><Text>Cancelar</Text></TouchableOpacity></Dialog.Actions>
                            </View>
                        </Dialog.Content>
                    </Dialog>
                </Portal>
            </Container>
        </>
    );
}

const styles = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    container: {
        flex: 1,
    },
    scrollView: {
        backgroundColor: theme.colors.white,
        marginHorizontal: 0,
        flexGrow: 1,
        height: '100%',
        marginBottom: 'auto',
    },
    buttonADD: {
        alignItems: 'center',
        alignSelf: 'center',
        marginVertical: 25,
        width: '60%',
        height: 'auto',
    },
    buttonText: {
        color: theme.colors.white,
        fontSize: 20,
    },
    buttonBorder: {
        width: '100%',
        alignSelf: 'center',
        paddingVertical: 10,
        borderRadius: 20,
        borderWidth: 1,
        borderColor: theme.colors.whitepure,
        justifyContent: 'center',
        alignItems: 'center',
    },
    corpo: {
        height: '75%',
        width: '100%',

    },
    tabela: {
        marginHorizontal: '5%',
        flexDirection: 'row',
        alignItems: 'center',
    },
    norma1: { width: '35%', fontWeight: 'bold' },
    norma2: { width: 'auto', textAlignVertical: 'center' },
    norma3: { width: 'auto', marginHorizontal: 10, textAlignVertical: 'center' },
    norma4: { width: 'auto', textAlignVertical: 'center' },
    norma5: { width: '30%', alignItems: 'center' },
    norma6: { width: '65%', textAlignVertical: 'center' },

    checkbox: {
        flexDirection: 'row',
        alignItems: 'baseline',
        marginTop: '5%',
        width: 'auto',
        marginBottom: '-4%',
        paddingLeft: '5%',
    },

    dialog: {
        padding: 5,
        borderRadius: 20,
        position: 'absolute',
        height: 'auto',
        width: '90%',
        alignItems: 'center',
        justifyContent: 'center',
        alignSelf: 'center',
        marginVertical: '20%',
    },

    touchDialog: {
        height: 40,
        width: 40,
        borderWidth: 1,
        borderRadius: 40,
        alignItems: 'center',
        justifyContent: 'center',
        marginHorizontal: 5,
        borderColor: theme.colors.red,
        backgroundColor: 'rgba(255,0,0,0.25)',
    },
    touchDialog2: {
        height: 40,
        width: 40,
        borderWidth: 1,
        borderRadius: 40,
        alignItems: 'center',
        justifyContent: 'center',
        marginHorizontal: 5,
        borderColor: theme.colors.green2,
        backgroundColor: 'rgba(0,125,0,0.25)',
    },
    touchDialog3: {
        borderWidth: 1,
        paddingHorizontal: 10,
        paddingVertical: 5,
        borderRadius: 80,
        marginTop: 'auto',
        marginBottom: 0,
    },
    hourView: {
        flexDirection: 'column',
        backgroundColor: '#E7E7E7',
        alignItems: 'flex-start',
        width: '40%',
        borderBottomColor: '#000',
        borderBottomWidth: 1,
        paddingTop: '3%',
        paddingLeft: '3%',
        borderRadius: 8,
    },
    hourView2: {
        flexDirection: 'column',
        backgroundColor: '#999',
        alignItems: 'flex-start',
        width: '40%',
        borderBottomColor: '#000',
        borderBottomWidth: 1,
        paddingTop: '3%',
        paddingLeft: '3%',
        borderRadius: 8,
        borderColor: '#ff0000',
        borderWidth: 1,
    },
});