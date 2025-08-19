import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';

import { type BreadcrumbItem } from '@/types';

interface Props {
    user: {
        id: number;
        name: string;
        email: string;
        role: {
            id: number;
            name: string;
            display_name: string;
        } | null;
    };
    stats?: {
        total_students?: number;
        total_teachers?: number;
        total_courses?: number;
        total_users?: number;
        enrolled_courses?: number;
        gpa?: number;
        attendance_rate?: number;
        total_children?: number;
        pending_grades?: number;
    };
    courses?: Array<{
        id: number;
        name: string;
        code: string;
        grade_level: string;
        students?: Array<{ id: number; user: { name: string } }>;
        teacher?: { user?: { name: string } };
    }>;
    children?: Array<{
        id: number;
        user: { name: string };
        student_id: string;
        grade_level: string;
        status: string;
        courses?: Array<{ id: number; name: string; code: string }>;
    }>;
    recent_grades?: Array<{
        id: number;
        assignment_name: string;
        letter_grade: string;
        percentage: number;
        course?: { name: string };
    }>;
    recent_enrollments?: Array<{
        id: number;
        user: { name: string };
        grade_level: string;
        student_id: string;
        created_at: string;
    }>;
    student?: {
        id: number;
        student_id: string;
        grade_level: string;
        enrollment_date: string;
        status: string;
    };
    teacher?: {
        id: number;
        employee_id: string;
        department: string;
        subject_specialization: string;
        hire_date: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ user, stats, courses, children, recent_grades, recent_enrollments, student, teacher }: Props) {
    const renderAdminDashboard = () => (
        <div className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Total Students</p>
                            <p className="text-3xl font-bold text-blue-600">{stats?.total_students || 0}</p>
                        </div>
                        <div className="text-4xl">👨‍🎓</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Total Teachers</p>
                            <p className="text-3xl font-bold text-green-600">{stats?.total_teachers || 0}</p>
                        </div>
                        <div className="text-4xl">👩‍🏫</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Active Courses</p>
                            <p className="text-3xl font-bold text-purple-600">{stats?.total_courses || 0}</p>
                        </div>
                        <div className="text-4xl">📚</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Total Users</p>
                            <p className="text-3xl font-bold text-orange-600">{stats?.total_users || 0}</p>
                        </div>
                        <div className="text-4xl">👥</div>
                    </div>
                </div>
            </div>

            {recent_enrollments && recent_enrollments.length > 0 && (
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4">Recent Student Enrollments</h3>
                    <div className="space-y-3">
                        {recent_enrollments.map((enrollment) => (
                            <div key={enrollment.id} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <p className="font-medium">{enrollment.user.name}</p>
                                    <p className="text-sm text-gray-600">Grade {enrollment.grade_level} • Student ID: {enrollment.student_id}</p>
                                </div>
                                <span className="text-sm text-gray-500">
                                    {new Date(enrollment.created_at).toLocaleDateString()}
                                </span>
                            </div>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );

    const renderTeacherDashboard = () => (
        <div className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">My Courses</p>
                            <p className="text-3xl font-bold text-blue-600">{stats?.total_courses || 0}</p>
                        </div>
                        <div className="text-4xl">📚</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Total Students</p>
                            <p className="text-3xl font-bold text-green-600">{stats?.total_students || 0}</p>
                        </div>
                        <div className="text-4xl">👨‍🎓</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Pending Grades</p>
                            <p className="text-3xl font-bold text-orange-600">{stats?.pending_grades || 0}</p>
                        </div>
                        <div className="text-4xl">📝</div>
                    </div>
                </div>
            </div>

            {teacher && (
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4">Teacher Information</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p className="text-sm text-gray-600">Employee ID</p>
                            <p className="font-medium">{teacher.employee_id}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600">Department</p>
                            <p className="font-medium">{teacher.department}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600">Subject Specialization</p>
                            <p className="font-medium">{teacher.subject_specialization}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600">Hire Date</p>
                            <p className="font-medium">{new Date(teacher.hire_date).toLocaleDateString()}</p>
                        </div>
                    </div>
                </div>
            )}

            {courses && courses.length > 0 && (
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4">My Courses</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {courses.map((course) => (
                            <div key={course.id} className="border rounded-lg p-4">
                                <h4 className="font-semibold">{course.name}</h4>
                                <p className="text-sm text-gray-600">{course.code}</p>
                                <p className="text-sm text-gray-600">Grade {course.grade_level}</p>
                                <p className="text-sm text-gray-600 mt-2">
                                    {course.students?.length || 0} students enrolled
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );

    const renderStudentDashboard = () => (
        <div className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Enrolled Courses</p>
                            <p className="text-3xl font-bold text-blue-600">{stats?.enrolled_courses || 0}</p>
                        </div>
                        <div className="text-4xl">📚</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">GPA</p>
                            <p className="text-3xl font-bold text-green-600">{stats?.gpa || '0.0'}</p>
                        </div>
                        <div className="text-4xl">🎯</div>
                    </div>
                </div>
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">Attendance Rate</p>
                            <p className="text-3xl font-bold text-purple-600">{stats?.attendance_rate || 100}%</p>
                        </div>
                        <div className="text-4xl">📊</div>
                    </div>
                </div>
            </div>

            {student && (
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4">Student Information</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p className="text-sm text-gray-600">Student ID</p>
                            <p className="font-medium">{student.student_id}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600">Grade Level</p>
                            <p className="font-medium">{student.grade_level}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600">Enrollment Date</p>
                            <p className="font-medium">{new Date(student.enrollment_date).toLocaleDateString()}</p>
                        </div>
                        <div>
                            <p className="text-sm text-gray-600">Status</p>
                            <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                student.status === 'active' 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-gray-100 text-gray-800'
                            }`}>
                                {student.status}
                            </span>
                        </div>
                    </div>
                </div>
            )}

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {courses && courses.length > 0 && (
                    <div className="bg-white rounded-lg p-6 shadow-sm border">
                        <h3 className="text-lg font-semibold mb-4">My Courses</h3>
                        <div className="space-y-3">
                            {courses.map((course) => (
                                <div key={course.id} className="border rounded-lg p-4">
                                    <h4 className="font-semibold">{course.name}</h4>
                                    <p className="text-sm text-gray-600">{course.code}</p>
                                    <p className="text-sm text-gray-600">
                                        Teacher: {course.teacher?.user?.name || 'Not assigned'}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                {recent_grades && recent_grades.length > 0 && (
                    <div className="bg-white rounded-lg p-6 shadow-sm border">
                        <h3 className="text-lg font-semibold mb-4">Recent Grades</h3>
                        <div className="space-y-3">
                            {recent_grades.map((grade) => (
                                <div key={grade.id} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <p className="font-medium">{grade.assignment_name}</p>
                                        <p className="text-sm text-gray-600">{grade.course?.name}</p>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-bold text-lg">{grade.letter_grade || 'N/A'}</p>
                                        <p className="text-sm text-gray-600">{grade.percentage}%</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );

    const renderParentDashboard = () => (
        <div className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-sm font-medium text-gray-600">My Children</p>
                            <p className="text-3xl font-bold text-blue-600">{stats?.total_children || 0}</p>
                        </div>
                        <div className="text-4xl">👪</div>
                    </div>
                </div>
            </div>

            {children && children.length > 0 && (
                <div className="bg-white rounded-lg p-6 shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4">My Children</h3>
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {children.map((child) => (
                            <div key={child.id} className="border rounded-lg p-4">
                                <h4 className="font-semibold text-lg mb-2">{child.user.name}</h4>
                                <div className="space-y-2 text-sm">
                                    <p><span className="text-gray-600">Student ID:</span> {child.student_id}</p>
                                    <p><span className="text-gray-600">Grade Level:</span> {child.grade_level}</p>
                                    <p><span className="text-gray-600">Status:</span> 
                                        <span className={`ml-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                            child.status === 'active' 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-gray-100 text-gray-800'
                                        }`}>
                                            {child.status}
                                        </span>
                                    </p>
                                    <p><span className="text-gray-600">Courses:</span> {child.courses?.length || 0}</p>
                                </div>
                                {child.courses && child.courses.length > 0 && (
                                    <div className="mt-4">
                                        <p className="text-sm font-medium text-gray-700 mb-2">Current Courses:</p>
                                        <div className="space-y-1">
                                            {child.courses.slice(0, 3).map((course) => (
                                                <p key={course.id} className="text-xs text-gray-600">
                                                    {course.name} ({course.code})
                                                </p>
                                            ))}
                                            {child.courses.length > 3 && (
                                                <p className="text-xs text-gray-500">
                                                    +{child.courses.length - 3} more courses
                                                </p>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );

    const getDashboardContent = () => {
        const roleName = user.role?.name;
        
        switch (roleName) {
            case 'admin':
                return renderAdminDashboard();
            case 'teacher':
                return renderTeacherDashboard();
            case 'student':
                return renderStudentDashboard();
            case 'parent':
                return renderParentDashboard();
            default:
                return (
                    <div className="text-center py-12">
                        <p className="text-gray-600">Please contact an administrator to assign you a role.</p>
                    </div>
                );
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">
                            Welcome back, {user.name}! 👋
                        </h1>
                        <p className="text-gray-600">
                            {user.role?.display_name || 'User'} Dashboard
                        </p>
                    </div>
                </div>
                
                {getDashboardContent()}
            </div>
        </AppLayout>
    );
}